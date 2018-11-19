<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\LeaveRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Overtime;
use App\Http\Models\Employee;
use App\Http\Controllers\EmailController;
use Input;
use Excel;
use Config;
use Lang;
use DateTime;

define('PAGINATE_TRUE', true);
define('PAGINATE_FALSE', false);

class LeaveRequestController extends Controller
{

    protected $LeaveRequest;

    function __construct(){

        $this->LeaveRequest     = new LeaveRequest();
        $this->mail             = new EmailController();
        $this->type             = Config::get('email_types.leave_request');
    }

    public function GetAll($paginate = true) {

        $employeeName   = Input::get('employeeName');
        $startDate      = Input::get('startDate');
        $endDate        = Input::get('endDate');
        $department     = Input::get('slc_department');

        $where = array();

        if (!empty($employeeName)) {
            $tmp = array (
                    'fields'    => 'employee.displayName',
                    'operator'  => 'LIKE',
                    'value'     => '%' . $employeeName . '%'
                );

            array_push($where, $tmp);
        }

        if (!empty($startDate)) {
            $tmp = array (
                    'fields'    => 'start_date',
                    'operator'  => '>=',
                    'value'     => $startDate . ' ' . '00:00:00'
                );

            array_push($where, $tmp);
        }

        if (!empty($endDate)) {
            $tmp = array (
                    'fields'    => 'start_date',
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

            $data = LeaveRequest::Search($where);
        } else {

            $data = LeaveRequest::Search($where, false);
        }

        $data = $this->format_employee_date($data);

        $data['extra']['search_startDate']  = $startDate;
        $data['extra']['search_endDate']    = $endDate;
        $data['extra']['search_empName']    = $employeeName;
        $data['extra']['search_department'] = $department;
        $data['extra']['search_where']      = $where;

        return $data;

    }

    public function GetOneEmp() {

		// $empCode 	= Input::get('empCode');
		// $date 		= Input::get('date');
		$id 		= Input::get('id');

		$where = [
			[
				'fields' 		=> 'holiday.id',
				'operator' 		=> '=',
				'value' 		=> $id
			]
		];

		$data = LeaveRequest::Search($where);

		$data = $this->format_employee_date($data);

		return $data;
	}

    public function GetDepartment() {

		$data = LeaveRequest::GetDepartment();

		return $data;
	}

	public function Update() {

        $employeeFullName   = Input::get('employeeFullName');
		$current_start_date = Input::get('current_start_date');
        $current_end_date 	= Input::get('current_end_date');
        $start_date 		= Input::get('start_date');
        $end_date 			= Input::get('end_date');
        $email              = Input::get('email');
        $approve            = 0;
        $types              = 0;

        if (!empty(Input::get('slc_approve'))) {

            $approve        = Input::get('slc_approve');
        }

        if (!empty(Input::get('types'))) {

            $types = Input::get('types');
        }

        $empCode 			= Input::get('empCode');
        $note               = Input::get('note');
        $employee_id		= Input::get('employee_id');

        $approvedDate		= null;


        if ($this->CheckValidDate($current_start_date) == null || $this->CheckValidDate($current_end_date) == null || $this->CheckValidDate($start_date) == null || $this->CheckValidDate($end_date) == null) {
        	return false;
        }

        if ($approve == '1') {
        	$approvedDate = date("Y-m-d H:i:s");
        }

        $data = [
            'start_date' 			=> $start_date,
            'end_date'   			=> $end_date,
            'isApproved'			=> $approve,
            'approvedDate'			=> $approvedDate,
            'note'                  => $note,
            'types'					=> $types
        ];

        $data_email = [
            'employeeFullName'      => $employeeFullName,
            'start_date'            => $start_date,
            'end_date'              => $end_date,
            'isApproved'            => $approve,
            'approvedDate'          => $approvedDate,
            'note'                  => $note,
            'types'                 => $types
        ];

        $where = [
            [
                'fields'    	=> 'employeeId',
                'operator'  	=> '=',
                'value'     	=> $employee_id
            ],
            [
                'fields'    	=> 'start_date',
                'operator'  	=> '=',
                'value'     	=> $current_start_date
            ],
            [
                'fields'    	=> 'end_date',
                'operator'  	=> '=',
                'value'     	=> $current_end_date
            ]
        ];

        $data = LeaveRequest::UpdateData('holiday', $data, $where);

        // $this->mail->sendMail($this->type, $data_email, $email);

        $search_condition = [

        ];

        return $search_condition;
    }

    private function CheckValidDate($date) {

    	$timestamp = strtotime($date);

    	return $timestamp ? $date : null;
    }

    private function format_employee_date($data) {

		foreach ($data['response'] as $key => $value) {
			$tmp_startTime 	= strtotime($value->start_date);
			$tmp_endTime 	= strtotime($value->end_date);

			$value->startDate 	= date("Y-m-d", $tmp_startTime);
			$value->endDate 	= date("Y-m-d", $tmp_endTime);
			$value->startTime 	= date("H:i", $tmp_startTime);
			$value->endTime 	= date("H:i", $tmp_endTime);
		}

		return $data;
	}

	public function export() {

        $data 	= array();
        $result = $this->GetAll(PAGINATE_FALSE);

        // dd($result);

        $array_key = [
            'firstname',
            'lastname',
            'employeeCode',
            'email',
            'types',
            'approvedDate',
            'isApproved',
            'note',
            'approver_firstname',
            'approver_lastname',
            'startDate',
            'endDate',
            'startTime',
            'endTime'
        ];

        $array_title = [
            'firstname'             => Lang::get('admin/leave_request.firstname'),
            'lastname'              => Lang::get('admin/leave_request.lastname'),
            'employeeCode'          => Lang::get('admin/leave_request.employee_code'),
            'email'                 => Lang::get('admin/leave_request.email'),
            'startDate'             => Lang::get('admin/leave_request.startDate'),
            'endDate'               => Lang::get('admin/leave_request.endDate'),
            'startTime'             => Lang::get('admin/leave_request.startTime'),
            'endTime'               => Lang::get('admin/leave_request.endTime'),
            'date_diff'             => Lang::get('admin/leave_request.date_diff'),
            'types'                 => Lang::get('admin/leave_request.types'),
            'isApproved'            => Lang::get('admin/leave_request.status'),
            'approvedDate'          => Lang::get('admin/leave_request.approvedDate'),
            'note'                  => Lang::get('admin/leave_request.note'),
            'approver_firstname'    => Lang::get('admin/leave_request.approver_firstname'),
            'approver_lastname'     => Lang::get('admin/leave_request.approver_lastname'),
        ];

        // change types and isApproved from number to meaningful string
        foreach ($result['response'] as $rs => $tmp_data) {

            $tmp = array();
            foreach ($tmp_data as $key => $value) {
                if (in_array($key, $array_key)) {

                    if ($key == 'types') {

                        $value = $this->checkLeaveTypes($value);
                    }

                    if ($key == 'isApproved') {

                        $value = $this->checkStatusApprove($value);
                    }

                    if ($key == 'startDate') {

                        $tmp['date_diff'] = $this->getDateDifference($tmp_data->start_date, $tmp_data->end_date);
                    }

                    $tmp[$key] = $value;
                }
            }
           array_push($data, $tmp);
        }

        // dd($data);

        return Excel::create('leave_request_'.date('Ymdhis'), function($excel) use ($data, $array_title) {
           $excel->sheet('mySheet', function($sheet) use ($data, $array_title)
           {
                //change position of data column
                $excel_array = $this->formatExcelData($data, $array_title);

                $sheet->fromArray($excel_array, null, 'A1', false, false);

                $sheet->prependRow(1, $array_title);
           });
       })->download('xlsx');

    }

    public function formatExcelData($array_data, $array_title) {

        $result         = [];
        $tmp_array      = [];

        // dd($array_data);

        foreach ($array_data as $data_key => $data_value) {

            foreach ($array_title as $title_key => $title_value) {

                if ($title_key == 'date_diff') {

                    $data_value[$title_key]['hours']    = $this->formatTime($data_value[$title_key]['hours']);
                    $data_value[$title_key]['minutes']  = $this->formatTime($data_value[$title_key]['minutes']);

                    $tmp_array[$title_key] = $data_value[$title_key]['hours'] . ':' . $data_value[$title_key]['minutes'];
                } else {

                    $tmp_array[$title_key] = $data_value[$title_key];
                }

            }

            array_push($result, $tmp_array);
        }

        return $result;
    }

    private function getDateDifference($start_date, $end_date) {

        $total_worktime_per_day = Config::get('mycnf.total_worktime_per_day');
        $weekDays               = $this->countWeekDays($start_date, $end_date);
        $start_datetime         = new DateTime($start_date);
        $end_datetime           = new DateTime($end_date);
        $hours                  = null;
        $difference             = $start_datetime->diff($end_datetime);

        // $weeks =  $difference->d % 7;
        // if ($weeks >= 5) {

        //     $weeks = round($difference->d / 7);
        // } else {

        //     $weeks = floor($difference->d / 7);
        // }

        if ( $difference->d == 0 && ($difference->h > $total_worktime_per_day) ) {

            $hours = $difference->h - (24 - $total_worktime_per_day);
        }
        elseif ( $difference->d > 0 && ($difference->h > $total_worktime_per_day) ) {

            $hours = ($difference->d - $weekDays) * $total_worktime_per_day + $difference->h - (24 - $total_worktime_per_day);
        }
        else {

            $hours = ($difference->d - $weekDays) * $total_worktime_per_day + $difference->h;
        }

        $results = [
            'days'      => $difference->d,
            'hours'     => $hours,
            'minutes'   => $difference->i,
        ];

        // dd($weekDays);

        return $results;
    }

    private function countWeekDays($start_date, $end_date) {

        $start_date = date('w', strtotime($start_date));
        $end_date   = date('w', strtotime($end_date));
        $count      = 0;

        // value 6 is Saturday, value 0 is Sunday
        // in our company, day off are Saturday and Sunday

        if ($start_date == $end_date) {

            $count = 0;
        }

        elseif ($start_date < $end_date) {

            if ($start_date == 0) {

                $count = 1;
            }
            if ($end_date == 6) {

                $count = 1;
            }
        }

        else {

            if ($start_date <= 5 && $end_date == 0) {

                $count = 1;
            }
            if ($start_date <= 5 && $end_date > 0) {

                $count = 2;
            }
            // if ($start_date == 6) {

            //     $count = 2;
            // }
            // if ($start_date == 0) {

            //     $count = 1;
            // }
        }

        return $count;
    }

    // function isWeekend($date) {

    //     $weekDay = date('w', strtotime($date));

    //     return ($weekDay == 0 || $weekDay == 6);
    // }

    private function checkLeaveTypes($type) {

        $arr_leave_types        = Config::get('leave_types');
        $count                  = count($arr_leave_types);

        for ($i = 0; $i< $count; $i++) {
            if ($type == $i) {

                $type = $arr_leave_types[$i];
            }
        }

        return $type;
    }

    private function formatTime($time) {

        if ($time >= 0 && $time < 10) {

            $time = '0' . $time;
        }

        return $time;
    }

    private function checkStatusApprove($status) {

        if ($status == 0) {

            $status = Lang::get('admin/leave_request.not_approved');
        } else if ($status == 1) {

            $status = Lang::get('admin/leave_request.approved');
        } else if ($status == 2) {

            $status = Lang::get('admin/leave_request.reject');
        }

        return $status;
    }

    public function addLeaveRequest(){
        $employeeId = Auth::user()->id;;
        $startDate  = Input::get('startDate');
        $startTime  = $startDate.' '.Input::get('startTime');
        $endDate    = Input::get('endDate');
        $endTime    = $endDate.' '.Input::get('endTime');
        $approverId = Input::get('approverId');
        $typeId     = Input::get('typeId');
        $note       = Input::get('note');
        // unset($data['_token']);
        $data=[
        'employeeId'    => $employeeId,
        'approverId'    => $approverId,
        'start_date'    => $startTime,
        'end_date'      => $endTime,
        'types'         => $typeId,
        'note'          => $note
        ];

        $this->LeaveRequest->addLeaveRequest($data);
    }
    public function GetAll_front($paginate = PAGINATE_TRUE) {


        $endDate            = Input::get('endDate');
        // $approve             = Input::get('slc_approve');
        $startDate          = Input::get('startDate');
        // $department      = Input::get('slc_department');
        // $employeeName       = Input::get('employeeName');
        $emp_id             = Auth::user()->id;


        $where              = array();
        // if (!empty($employeeName)) {
        //     $tmp = array (
        //             'fields'    => 'displayName',
        //             'operator'  => 'LIKE',
        //             'value'     => '%' . $employeeName . '%'
        //         );

        //     array_push($where, $tmp);
        // }

        if (!empty($startDate)) {
            $tmp = array (
                    'fields'    => 'start_date',
                    'operator'  => '>=',
                    'value'     => $startDate . ' ' . '00:00:00'
                );

            array_push($where, $tmp);
        }

        if (!empty($endDate)) {
            $tmp = array (
                    'fields'    => 'start_date',
                    'operator'  => '<=',
                    'value'     => $endDate . ' ' . '23:59:59'
                );

            array_push($where, $tmp);
        }

        if ($paginate == true) {
            $emp_id = Auth::user()->id;
            $data = LeaveRequest::Search_front($where, $emp_id);
        } else {
            $data = LeaveRequest::Search_front($where, $emp_id, false);
        }


        $data = $this->format_date($data);

        $data['extra']['search_startDate']  = $startDate;
        $data['extra']['search_endDate']    = $endDate;
        $data['extra']['search_where']      = $where;

        return $data;

    }

    public function format_date($data){
        foreach ($data['response'] as $key => $value) {
            $tmp_startTime  = strtotime($value->start_date);
            $tmp_endTime    = strtotime($value->end_date);

            $value->startDate   = date("Y-m-d", $tmp_startTime);
            $value->endDate     = date("Y-m-d", $tmp_endTime);
            $value->startTime   = date("H:i", $tmp_startTime);
            $value->endTime     = date("H:i", $tmp_endTime);
            switch ($value->types) {
                    case '0':
                        $value->types = Lang::get('user/leave_request_report.type_LQ_0');
                        break;

                    case '1':
                        $value->types = Lang::get('user/leave_request_report.type_LQ_1');
                        break;

                    case '2':
                        $value->types = Lang::get('user/leave_request_report.type_LQ_2');
                        break;
                }

                switch ($value->approverId) {
                    case '1':
                        $value->approverId = Lang::get('user/leave_request_report.approverId_1');
                        break;

                    case '2':
                        $value->approverId = Lang::get('user/leave_request_report.approverId_2');
                        break;

                    case '3':
                        $value->approverId = Lang::get('user/leave_request_report.approverId_3');
                        break;

                    default:
                        # code...
                        break;
                }
            }
        return $data;
    }
    // public function searchLeaveRequest($export=false){
    //     // print_r(Auth::user()->id);
    //     // exit();
    //     $empId      = Auth::user()->id;
    //     $startDate  = Input::get('startDate');
    //     $endDate    = Input::get('endDate');

    //     $where = array();

    //     if (!empty($empId)) {
    //         $tmp = array (
    //                 'fields'    => 'employeeId',
    //                 'operator'  => '=',
    //                 'value'     => $empId
    //             );

    //         array_push($where, $tmp);
    //     }

    //     if (!empty($startDate)) {
    //         $tmp = array (
    //                 'fields'    => 'start_date',
    //                 'operator'  => '>=',
    //                 'value'     => $startDate . ' ' . '00:00:00'
    //             );

    //         array_push($where, $tmp);
    //     }

    //     if (!empty($endDate)) {
    //         $tmp = array (
    //                 'fields'    => 'start_date',
    //                 'operator'  => '<=',
    //                 'value'     => $endDate . ' ' . '23:59:59'
    //             );

    //         array_push($where, $tmp);
    //     }
    //     if ($export==false) {
    //         $data['response'] = $this->timesheet->searchByDate($where);
    //     }else{
    //         $data['response'] = $this->timesheet->searchByDate($where,$export);
    //     }
    //     $data['search']['search_startDate'] = $startDate;
    //     $data['search']['search_endDate']   = $endDate;
    //     $data['search']['search_empId']     = $empId;

    //     $data = $this->formatDate($data);

    //     return $data;
    // }
    public function exportLeaveRequest() {
        $result = $this->GetAll_front(PAGINATE_FALSE);

        $data = array();


        foreach ($result['response'] as $key => $value) {
            $tmp = array();
            foreach ($value as $k => $v) {
                $tmp = array(
                    $value->employee_id,
                    $value->startDate . ' ' . $value->startTime,
                    $value->endDate   . ' ' . $value->endTime,
                    $value->types,
                    $value->approverId,
                    $value->approvedDate,
                    $value->note,
                );


               // $tmp[$k] = $v;

            }
            array_push($data, $tmp);
        }

        return Excel::create('LeaveRequest_Data_'.date('Ymdhis'), function($excel) use ($data) {
           $excel->sheet('mySheet', function($sheet) use ($data)
           {
               $sheet->fromArray($data, null, 'A1', false, false);

               $sheet->prependRow(1, array(Lang::get('user/leave_request_report.em_id'),
                                           Lang::get('user/leave_request_report.start_date'),
                                           Lang::get('user/leave_request_report.end_date'),
                                           Lang::get('user/leave_request_report.types'),
                                           Lang::get('user/leave_request_report.approver'),
                                           Lang::get('user/leave_request_report.approved_date'),
                                           Lang::get('user/leave_request_report.note')));
           });
       })->download('xlsx');
    }
}