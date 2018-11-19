<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Timesheet;
use DateTime;
use Config;
use Input;
use Excel;
use Lang;
use Auth;
use Session;

// define('PAGINATE_TRUE', true);
// define('PAGINATE_FALSE', false);

class TimesheetController extends Controller
{
    protected $timesheet;

    function __construct(){
        $this->timesheet= new Timesheet();
    }



    // start admin controller
    public function GetAllEmp($paginate = true) {

        $employeeName   = Input::get('employeeName');
        $startDate      = Input::get('startDate');
        $endDate        = Input::get('endDate');
        $department     = Input::get('slc_department');

        $where = array();

        if (!empty($employeeName)) {
            $tmp = array (
                    'fields'    => 'displayName',
                    'operator'  => 'LIKE',
                    'value'     => '%' . $employeeName . '%'
                );

            array_push($where, $tmp);
        }

        if (!empty($startDate)) {
            $tmp = array (
                    'fields'    => 'date',
                    'operator'  => '>=',
                    'value'     => $startDate . ' ' . '00:00:00'
                );

            array_push($where, $tmp);
        }

        if (!empty($endDate)) {
            $tmp = array (
                    'fields'    => 'date',
                    'operator'  => '<=',
                    'value'     => $endDate . ' ' . '23:59:59'
                );

            array_push($where, $tmp);
        }

        if (!empty($department)) {
            $tmp = array (
                    'fields'        => 'department.id',
                    'operator'      => '=',
                    'value'         => $department
                );

            array_push($where, $tmp);
        }

        if ($paginate == true) {

            $data = Timesheet::Search($where);
        } else {

            $data = Timesheet::Search($where, false);
        }

        $data = $this->format_employee_date($data);

        $data['extra']['search_startDate']  = $startDate;
        $data['extra']['search_endDate']    = $endDate;
        $data['extra']['search_empName']    = $employeeName;
        $data['extra']['search_department'] = $department;
        $data['extra']['search_where']      = $where;

        return $data;

    }

    public function GetDepartment() {

        $data = Timesheet::GetDepartment();

        return $data;
    }

    public function GetOneEmp() {

        $empCode = Input::get('empCode');
        $date = Input::get('date');

        $where = [
            [
                'fields'    => 'employeeCode',
                'operator'  => '=',
                'value'     => $empCode
            ],
            [
                'fields'    => 'date',
                'operator'  => '=',
                'value'     => $date
            ]
        ];

        $data = Timesheet::Search($where);

        $data = $this->format_employee_date($data);

        return $data;
    }

    public function Update() {

        $empCode    = Input::get('empCode');
        $date       = Input::get('date');
        $startDate  = Input::get('startDate');
        $endDate    = Input::get('endDate');
        $note       = Input::get('note');
        $data = [
            'startDate' => $date . ' ' . $startDate,
            'endDate'   => $date . ' ' . $endDate,
            'note'      => $note
        ];

        $where = [
            [
                'fields'    => 'employeeId',
                'operator'  => '=',
                'value'     => $empCode
            ],
            [
                'fields'    => 'date',
                'operator'  => '=',
                'value'     => $date
            ]
        ];

        $data   = Timesheet::UpdateData('workingtime', $data, $where);

        $allEmp = $this->GetAllEmp();

        return $allEmp;
    }

    public function export() {
        $result = $this->GetAllEmp(false);

        $data   = array();

        foreach ($result['response'] as $key => $value) {
           $tmp = array();

           foreach ($value as $k => $v) {
               $tmp[$k] = $v;
           }

           array_push($data, $tmp);
        }

        return Excel::create('export_data'.date('Ymdhis'), function($excel) use ($data) {

           $excel->sheet('mySheet', function($sheet) use ($data)
           {
               $sheet->fromArray($data);
           });

       })->download('xlsx');
    }

    private function format_employee_date($data) {

        foreach ($data['response'] as $key => $value) {

            $tmp_startDate  = strtotime($value->startDate);
            $tmp_endDate    = strtotime($value->endDate);
            $tmp_date       = strtotime($value->date);

            $date1          = new DateTime($value->startDate);

            if (isset($tmp_endDate) && $tmp_endDate != '') {

                $date2          = new DateTime($value->endDate);
                $diff           = date_diff($date1,$date2);
                $workTime       = strtotime($diff->format("%H:%i:%s"));

                $value->endDate     = date("H:i", $tmp_endDate);

                $start_noon_time    = $tmp_date + 11.5*60*60;
                $end_noon_time      = $tmp_date + 13*60*60;

                if (($tmp_startDate <= $start_noon_time && $tmp_endDate <= $start_noon_time) || ($tmp_startDate >= $end_noon_time && $tmp_endDate >= $end_noon_time) || ($tmp_startDate >= $start_noon_time && $tmp_startDate <= $end_noon_time)) {

                    $value->workTime = date("H:i", $workTime);

                } else {

                    $value->workTime = date("H:i", $workTime - Config::get('mycnf.rest_time')*60*60);

                }
            }

            $value->startDate   = date("H:i", $tmp_startDate);
            $value->lateTime    = 0;
            $tmp_lateTime       = $tmp_startDate - ($tmp_date + Config::get('mycnf.start_work_time')*60*60);

            if ($tmp_lateTime > 0) {

                $value->lateTime    = date("H:i", $tmp_startDate - Config::get('mycnf.start_work_time')*60*60);
            }
        }
        
        return $data;
    }

    // end admin controller




    // Start user controller

    public function getTimesheetRecent(){
        $emp_id             = Auth::user()->id;
        $data['response']   = $this->timesheet->getInformRecent($emp_id);
        $data               = $this->formatDate($data);
        return $data;
    }

    public function getTimesheetChart(){
        $emp_id             = Auth::user()->id;
        $data['chart']      = $this->timesheet->getInformChart($emp_id);
        return $data;
    }

    public function checkActiveButton(){
        $emp_id     = Auth::user()->id;
        @$startDate = $this->timesheet->getNewestDate($emp_id)->startDate;
        $dt         = strtotime($startDate);
        $startDate2 = date('Y-m-d',$dt);

        @$endDate   = $this->timesheet->getNewestDate($emp_id)->endDate;
        $dt2        = strtotime($endDate);
        $endDate2   = date('Y-m-d',$dt2);

        if (date('Y-m-d')<=($startDate2)&&date('Y-m-d')<=$endDate2) {
            //disabled checkin, checkout button
            $active=0;
        }
        elseif (date('Y-m-d')<=($startDate2)) {
            //disabled checkin
            $active=1;
        }else{
            //nothing
            $active=2;
        }
        return $active;
    }

    public function getNewestDate(){

        $emp_id = Auth::user()->id;
        $data   = $this->timesheet->getNewestDate($emp_id);
        return $data;

    }

    public function checkIn(){
        $emp_id     = Auth::user()->id;
        $date       = date('Y-m-d');
        $startDate  = date('Y-m-d H:i:s');

        $data=[
        'employeeId'=> $emp_id,
        'date'      => $date,
        'startDate' => $startDate,
        ];

        $info = $this->timesheet->statusCheckIn();
        if ($info == true){
            echo "Hom nay ban da check in roi!";
        }
        else {
            $this->timesheet->addTimesheet($data);
            Session::flash('success', Lang::get('user/timesheet_log.checkedIn'));
        }
    }

    public function checkOut(){
        // exit;
        // Neu co data start Date thi moi end Date
        $emp_id     = Auth::user()->id;
        $startDate  = $this->timesheet->getNewestDate($emp_id)->startDate;
        $endDate    = date('Y-m-d H:i:s');
        $note       = Input::get('note');

        $date   = $this->timesheet->getNewestDate($emp_id)->date;
        $id     = $this->timesheet->getNewestDate($emp_id)->id;

        if (date('Y-m-d') == ($date)) {
            // $totalTimePerDay = strtotime($endDate) - strtotime($startDate);
            $totalTimePerDay = $this->calculateTimePerDay(strtotime($startDate), strtotime($endDate));

            $lastDay           = cal_days_in_month (CAL_GREGORIAN, date('m'),date('Y'));
            $lastDayofMonth    = date('Y').'-'.date('m').'-'.$lastDay;
            $firstDayofMonth   = date('Y').'-'.date('m').'-1';
            $data              = $this->timesheet->getInfoByDate($emp_id,$firstDayofMonth,$lastDayofMonth);
            $totalTimePerMonth = 0;

            foreach ($data as $key => $value) {
               $timePerDay = $value->totalTimePerDay;
               $totalTimePerMonth += $timePerDay;
            }

            $checkout = [
               'endDate'            => $endDate,
               'totalTimePerDay'    => $totalTimePerDay,
               'totalTimePerMonth'  => ($totalTimePerMonth+$totalTimePerDay),
               'note'               => $note
            ];

            $info = $this->timesheet->statusCheckOut();
            if ($info == false){
                echo "Hom nay ban da check out roi!";
            }
            else{
                $this->timesheet->updateTimesheet($id,$checkout);
                Session::flash('success', Lang::get('user/timesheet_log.checkedOut'));
            }

        }else{
            print_r('Please checkin before checkout, today!');
            exit();
        }
    }


    public function calculateTimePerDay($startTime, $endTime){//startTime & endTime are strtotime

        $start_time = strtotime(Config::get('mycnf.start_time'));//8:30
        $end_time   = strtotime(Config::get('mycnf.end_time'));    //18
        $sleep_AM   = strtotime(Config::get('mycnf.sleep_AM'));    //11:30
        $start_PM   = strtotime(Config::get('mycnf.start_PM'));    //13

        if ($startTime < $sleep_AM) {

            if ($endTime < $sleep_AM) {
                $timePerDay = $endTime - $startTime;

            }elseif ($endTime > $sleep_AM && $endTime < $start_PM) {
                $timePerDay = $sleep_AM - $startTime;

            }elseif ($endTime > $start_PM) {
                $timePerDay = ($sleep_AM - $startTime) + ($endTime - $start_PM);
            }

        }elseif ($startTime >= $sleep_AM  && $startTime <= $start_PM) {

            if ($endTime > $sleep_AM && $endTime < $start_PM ) {
                $timePerDay = 0;

            }elseif ($endTime > $start_PM) {
                $timePerDay = $endTime - $start_PM;

            }

        }elseif ($startTime > $start_PM){
            $timePerDay = $endTime - $startTime;

        }

        return $timePerDay;
    }

    public function searchTimesheet($export=false){
        // print_r(Auth::user()->id);
        // exit();
        $empId      = Auth::user()->id;
        $startDate  = Input::get('startDate');
        $endDate    = Input::get('endDate');

        $where = array();

        if (!empty($empId)) {
            $tmp = array (
                    'fields'    => 'employeeId',
                    'operator'  => '=',
                    'value'     => $empId
                );

            array_push($where, $tmp);
        }

        if (!empty($startDate)) {
            $tmp = array (
                    'fields'    => 'date',
                    'operator'  => '>=',
                    'value'     => $startDate . ' ' . '00:00:00'
                );

            array_push($where, $tmp);
        }

        if (!empty($endDate)) {
            $tmp = array (
                    'fields'    => 'date',
                    'operator'  => '<=',
                    'value'     => $endDate . ' ' . '23:59:59'
                );

            array_push($where, $tmp);
        }
        if ($export==false) {
            $data['response'] = $this->timesheet->searchByDate($where);
        }else{
            $data['response'] = $this->timesheet->searchByDate($where,$export);
        }
        $data['search']['search_startDate'] = $startDate;
        $data['search']['search_endDate']   = $endDate;
        $data['search']['search_empId']     = $empId;

        $data = $this->formatDate($data);

        return $data;
    }


    public function exportTimesheet(){
        $result = $this->searchTimesheet(true);
        $data   = array();

        foreach ($result['response'] as $key => $value) {
           $tmp = array();
           foreach ($value as $k => $v) {
               $tmp[$k] = $v;
               unset($tmp['id']);
           }
           array_push($data, $tmp);
        }
        return Excel::create('WorkingTime_Data'.date('Y_m_d_h_i_s'), function($excel) use ($data) {
           $excel->sheet('mySheet', function($sheet) use ($data)
           {

               $sheet->fromArray($data, null, 'A1', false, false);

               $sheet->prependRow(1, array(Lang::get('user/timesheet_report.em_id'),
                                           Lang::get('user/timesheet_report.date'),
                                           Lang::get('user/timesheet_report.start_time'),
                                           Lang::get('user/timesheet_report.end_time'),
                                           Lang::get('user/timesheet_report.time_per_day'),
                                           Lang::get('user/timesheet_report.time_per_month'),
                                           Lang::get('user/timesheet_report.note')));

           });
       })->download('xlsx');
    }

    public function timeElapsed($secs){
        $h = $secs / 3600 % 24;
        $i = $secs / 60 % 60;
        if (strlen($h)==1) {
            $h='0'.$h;
        }
        if (strlen($i)==1) {
            $i='0'.$i;
        }
        // $s = $secs % 60;
        $result = $h .':'. $i;

    return $result;
    }

        public function formatDate($data){

        // date_default_timezone_set('Asia/Ho_Chi_Minh');

               foreach ($data['response'] as $key => $value) {
                   $tmp_startDate = strtotime($value->startDate);
                   $tmp_endDate   = strtotime($value->endDate);

                   $value->startDate = date("H:i", $tmp_startDate);
                   if (isset($value->endDate )) {
                       $value->endDate = date("H:i", $tmp_endDate);
                   }

                   //user GUI
                   $data['response'][$key]->timePerDayFormat   = $this->timeElapsed($value->totalTimePerDay);
                   $data['response'][$key]->timePerMonthFormat = $this->timeElapsed($value->totalTimePerMonth);
                   // echo "<pre>";
                   // print_r($data['response']);exit();

               }

               return $data;
        }

    public function checkStatusCheckIn(){
        $data  = $this->timesheet->statusCheckIn();
        return $data;
    }

    public function checkStatusCheckOut(){
        $data  = $this->timesheet->statusCheckOut();
        return $data;
    }
}
