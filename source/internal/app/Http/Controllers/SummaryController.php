<?php

namespace App\Http\Controllers;
use App\Http\Get\Helper;
use App\Http\Models\Base;
use Illuminate\Http\Request;
use App\Http\Models\LeaveRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Overtime;
use App\Http\Models\Employee;
use App\Http\Models\Summary;
use Input;
use Excel;
use Config;
use Lang;
use DateTime;

define('PAGINATE_TRUE', true);
define('PAGINATE_FALSE', false);

class SummaryController extends Controller
{

    protected $Summary;

    function __construct(){
        $this->Summary= new Summary();
    }

    public function GetAll($paginate = PAGINATE_TRUE, $employeeId = null) {

        $where              = array();
        $endDate            = Input::get('endDate');
        $approve            = Input::get('slc_approve');
        $startDate          = Input::get('startDate');
        $department         = Input::get('slc_department');
        $employeeName       = Input::get('employeeName');

        $data = Summary::Search($employeeName , $startDate, $endDate,  $employeeId, $department, $approve, Config::get('mycnf.paginate'));

        $data['extra']['search_startDate']  = $startDate;
        $data['extra']['search_endDate']    = $endDate;
        $data['extra']['search_empName']    = $employeeName;
        $data['extra']['search_department'] = $department;
        $data['extra']['search_approve']    = $approve;
        $data['extra']['search_where']      = $where;

        return $data;

    }

    public function GetOneEmp() {

        // $empCode     = Input::get('empCode');
        // $date        = Input::get('date');
        $id         = Input::get('id');

        $where = [
            [
                'fields'        => 'holiday.id',
                'operator'      => '=',
                'value'         => $id
            ]
        ];

        $data = Summary::Search($where);

        $data = $this->format_employee_date($data);

        return $data;
    }

    public function GetDepartment() {

        $data = Summary::GetDepartment();

        return $data;
    }

    public function Update() {

        $current_start_date = Input::get('current_start_date');
        $current_end_date   = Input::get('current_end_date');
        $start_date         = Input::get('start_date');
        $end_date           = Input::get('end_date');
        $approve            = Input::get('slc_approve');

        $empCode            = Input::get('empCode');
        $note               = Input::get('note');

        $approvedDate       = null;


        if ($this->CheckValidDate($current_start_date) == null || $this->CheckValidDate($current_end_date) == null || $this->CheckValidDate($start_date) == null || $this->CheckValidDate($end_date) == null) {
            return false;
        }

        if ($approve == '1') {
            $approvedDate = date("Y-m-d H:i:s");
        }

        $data = [
            'start_date'            => $start_date,
            'end_date'              => $end_date,
            'isApproved'            => $approve,
            'approvedDate'          => $approvedDate,
            'note'                  => $note
        ];

        $where = [
            [
                'fields'        => 'employeeId',
                'operator'      => '=',
                'value'         => $empCode
            ],
            [
                'fields'        => 'start_date',
                'operator'      => '=',
                'value'         => $current_start_date
            ],
            [
                'fields'        => 'end_date',
                'operator'      => '=',
                'value'         => $current_end_date
            ]
        ];

        $data = Summary::UpdateData('holiday', $data, $where);

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
            $tmp_startTime  = strtotime($value->start_date);
            $tmp_endTime    = strtotime($value->end_date);

            $value->startDate   = date("Y-m-d", $tmp_startTime);
            $value->endDate     = date("Y-m-d", $tmp_endTime);
            $value->startTime   = date("H:i", $tmp_startTime);
            $value->endTime     = date("H:i", $tmp_endTime);
        }

        return $data;
    }

    public function export() {
        $result = $this->GetAll(PAGINATE_FALSE);

        $data   = array();
        $where  = array();


        foreach ($result['response'] as $key => $value) {
            $tmp = array();
            foreach ($value as $k => $v) {
                $tmp = array(
                    $value->employeeCode,
                    $value->firstname . ' ' . $value->lastname,
                    $value->department_name,
                    $value->position_name,
                    $value->total_accepted_overtime,
                    $value->total_workingtime,
                    $value->approved_holiday,
                    $value->not_approve_holiday,
                );

               // $tmp[$k] = $v;
           }
            // echo "<pre>";
            // print_r($tmp);
            // exit;
            array_push($data, $tmp);
        }

        return Excel::create('Summary_Data_'.date('Ymdhis'), function($excel) use ($data) {
           $excel->sheet('mySheet', function($sheet) use ($data)
           {
               $sheet->fromArray($data, null, 'A1', false, false);
               $sheet->prependRow(1, array('From: ',
                                            ' To:',
                                            ));
               $sheet->prependRow(2, array(Lang::get('admin/summary.employee_code'),
                                           Lang::get('admin/summary.employee_name'),
                                           Lang::get('admin/summary.department_name'),
                                           Lang::get('admin/summary.position'),
                                           Lang::get('admin/summary.total_accepted_overtime'),
                                           Lang::get('admin/summary.total_workingtime'),
                                           Lang::get('admin/summary.approved_holiday'),
                                           Lang::get('admin/summary.not_approve_holiday')));
           });
       })->download('xlsx');
    }


    // start user controller

    public function GetEmployeCode() {

        return Auth::user()->employeeCode;
    }
}