<?php

namespace App\Http\Controllers;

// use App\User as modelUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Get\Helper;
use App\Http\Models\Base;
use App\Http\Models\Overtime;
use App\Http\Controllers\EmailController;
use Excel;
use Config;
use Lang;
use Hash;
use DateTime;
use app\Http\Requests;
use app\Http\Requests\OvertimeRequest;

define('PAGINATE_TRUE', true);
define('PAGINATE_FALSE', false);

class OvertimeController extends Controller
{

	protected $overtime;

    function __construct(){
        $this->overtime 	= new Overtime();
        $this->mail        	= new EmailController();
        $this->type 		= Config::get('email_types.overtime');
    }

	public function GetAll($paginate = PAGINATE_TRUE) {

		$where 				= array();
		$endDate 			= Input::get('endDate');
		$approve 			= Input::get('slc_approve');
		$startDate 			= Input::get('startDate');
		$department 		= Input::get('slc_department');
		$employeeName 		= Input::get('employeeName');


		if (!empty($employeeName)) {
			$tmp = array (
					'fields' 		=> 'employee.displayName',
					'operator'		=> 'LIKE',
					'value' 		=> '%' . $employeeName . '%'
				);

			array_push($where, $tmp);
		}

		if (!empty($startDate)) {
			$tmp = array (
					'fields' 		=> 'overtime.date',
					'operator'		=> '>=',
					'value' 		=> $startDate . ' ' . '00:00:00'
				);

			array_push($where, $tmp);
		}

		if (!empty($endDate)) {
			$tmp = array (
					'fields' 		=> 'overtime.date',
					'operator' 		=> '<=',
					'value' 		=> $endDate . ' ' . '23:59:59'
				);

			array_push($where, $tmp);
		}

		if (!empty($department)) {
			$tmp = array (
					'fields' 		=> 'department.id',
					'operator' 		=> '=',
					'value' 		=> $department
				);

			array_push($where, $tmp);
		}

		if ($approve != null && $approve != '') {
			$tmp = array (
					'fields' 		=> 'overtime.isApproved',
					'operator' 		=> '=',
					'value' 		=>  (int) $approve
				);

			array_push($where, $tmp);
		}

		// echo "<pre>";
		// print_r($where);
		// exit;


		if ($paginate == true) {

			$data = Overtime::Search($where);
		} else {

			$data = Overtime::Search($where, false);
		}


		$data = $this->format_employee_date($data);

		$data['extra']['search_startDate'] 	= $startDate;
		$data['extra']['search_endDate'] 	= $endDate;
		$data['extra']['search_empName'] 	= $employeeName;
		$data['extra']['search_department']	= $department;
		$data['extra']['search_approve'] 	= $approve;
		// $data['extra']['search_where'] 		= $where;

		return $data;

	}


	public function GetOneEmp() {

		// $empCode 	= Input::get('empCode');
		// $date 		= Input::get('date');
		$id 		= Input::get('id');

		$where = [
			// [
			// 	'fields' 		=> 'employee.employeeCode',
			// 	'operator' 		=> '=',
			// 	'value' 		=> $empCode
			// ],
			// [
			// 	'fields' 		=> 'date',
			// 	'operator' 		=> '=',
			// 	'value' 		=> $date
			// ]
			[
				'fields' 		=> 'overtime.id',
				'operator' 		=> '=',
				'value' 		=> $id
			]
		];

		$data = Overtime::Search($where);

		$data = $this->format_employee_date($data);

		return $data;
	}

	public function GetDepartment() {

		$data = Overtime::GetDepartment();

		return $data;
	}

	public function Update() {

        $startDate 			= Input::get('startDate');
        $endDate 			= Input::get('endDate');
        $employeeName 		= Input::get('employeeName');
        $projectName 		= Input::get('projectName');
        $approve 			= Input::get('slc_approve');
        $department			= Input::get('slc_department');
        $email				= Input::get('email');

        $employee_id        = Input::get('employee_id');
        $empCode 			= Input::get('empCode');
        $employeeFullName	= Input::get('employeeFullName');
        $date 				= Input::get('date');
        $currentDate 		= Input::get('currentDate');
        $startTime 			= Input::get('startTime');
        $endTime 			= Input::get('endTime');
        $note 				= Input::get('note');

        $search_approve		= Input::get('search_approve');
        $current_page		= Input::get('current_page');
        $approvedDate 		= null;

        if ($this->CheckValidDate($date) == null || $this->CheckValidDate($currentDate) == null || $this->CheckValidDate($startTime) == null || $this->CheckValidDate($endTime) == null) {
        	return false;
        }

        if ($approve == '1') {
        	$approvedDate = date("Y-m-d H:i:s");
        }

        $data = [
            'date' 					=> $date,
            'startTime' 			=> $date . ' ' . $startTime,
            'endTime'   			=> $date . ' ' . $endTime,
            'isApproved'			=> $approve,
            'approvedDate'			=> $approvedDate,
            'note'					=> $note
        ];

        $data_email = [
            'date' 					=> $date,
            'startTime' 			=> $date . ' ' . $startTime,
            'endTime'   			=> $date . ' ' . $endTime,
            'isApproved'			=> $approve,
            'approvedDate'			=> $approvedDate,
            'note'					=> $note,
            'employeeFullName'		=> $employeeFullName
        ];

        $where = [
            [
                'fields'    	=> 'employeeId',
                'operator'  	=> '=',
                'value'     	=> $employee_id
            ],
            [
                'fields'    	=> 'date',
                'operator'  	=> '=',
                'value'     	=> $currentDate
            ]
   			//[
			// 	'fields' 		=> 'id',
			// 	'operator' 		=> '=',
			// 	'value' 		=> $id
			// ]
        ];

        $data = Overtime::UpdateData('overtime', $data, $where);

        // $this->mail->sendMail($this->type, $data_email, $email);

        $search_condition = [
        	'search_startDate' 		=> $startDate,
        	'search_endDate'		=> $endDate,
        	'search_empName' 		=> $employeeName,
        	'search_projectName'	=> $projectName,
        	'search_approve' 		=> $search_approve,
        	'search_department' 	=> $department,
        	'current_page' 			=> $current_page,
        ];

        return $search_condition;
    }

    private function CheckValidDate($date) {

    	$timestamp = strtotime($date);

    	return $timestamp ? $date : null;
    }


	private function format_employee_date($data) {

		foreach ($data['response'] as $key => $value) {
			$tmp_startTime 	= strtotime($value->startTime);
			$tmp_endTime 	= strtotime($value->endTime);

			$value->startDate 	= date("Y-m-d", $tmp_startTime);
			$value->endDate 	= date("Y-m-d", $tmp_endTime);
			$value->startTime 	= date("H:i", $tmp_startTime);
			$value->endTime 	= date("H:i", $tmp_endTime);
			$value->lateTime 	= date("H:i", $tmp_startTime - Config::get('mycnf.start_work_time')*60*60);
			$value->workTime 	= date("H:i", $tmp_endTime - $tmp_startTime - Config::get('mycnf.rest_time')*60*60);

			$date1      		= new DateTime($value->startTime);
            $date2      		= new DateTime($value->endTime);
            $diff       		= date_diff($date1,$date2);
			$overTime   		= strtotime($diff->format("%H:%i:%s"));
			$value->overTime 	= date("H:i", $overTime);
		}

		return $data;
	}

	public function export() {
        $result = $this->GetAll(PAGINATE_FALSE);

        $data 	= array();

        $array_key = [
            // 'firstname',
            'lastname',
            // 'fullname',
            'employeeCode',
            'email',
            'date',
            'typeId',
            // 'system_check',
            'approvedDate',
            'isApproved',
            'note',
            'date',
            'startTime',
            'endTime',
            'overTime',
            // 'approver_firstname',
            'approver_lastname',
        ];


        $array_title = [
            // 'firstname'             => Lang::get('admin/overtime.firstname'),
            'lastname'              => Lang::get('admin/overtime.lastname'),
            // 'fullname'              => Lang::get('admin/overtime.fullname'),
            'employeeCode'          => Lang::get('admin/overtime.employee_code'),
            'email'                 => Lang::get('admin/overtime.email'),
            'date'                 	=> Lang::get('admin/overtime.date'),
            'startTime'           	=> Lang::get('admin/overtime.startTime'),
            'endTime'               => Lang::get('admin/overtime.endTime'),
            'overTime'              => Lang::get('admin/overtime.overTime'),
            'typeId'                => Lang::get('admin/overtime.types'),
            // 'system_check'         	=> Lang::get('admin/overtime.system_check'),
            'isApproved'            => Lang::get('admin/overtime.status'),
            'approvedDate'          => Lang::get('admin/overtime.approvedDate'),
            'note'                  => Lang::get('admin/overtime.note'),
            // 'approver_firstname'    => Lang::get('admin/overtime.approver_firstname'),
            'approver_lastname'     => Lang::get('admin/overtime.approver_lastname'),
        ];

        // change types and isApproved from number to meaningful string
        foreach ($result['response'] as $rs => $tmp_data) {

            $tmp = array();
            foreach ($tmp_data as $key => $value) {
                if (in_array($key, $array_key)) {

                    if ($key == 'lastname') {
                        
                        $value = $tmp_data->firstname . ' ' . $tmp_data->lastname;
                    }

                    if ($key == 'approver_lastname') {
                        
                        $value = $tmp_data->approver_firstname . ' ' . $tmp_data->approver_lastname;
                    }

                    if ($key == 'typeId') {

                        $value = $this->checkOvertimeTypes($value);
                    }

                    if ($key == 'isApproved') {

                        $value = $this->checkStatusApprove($value);
                    }

                    // if ($key == 'date') {

                    // 	$new_key 	= 'system_check';
                    //     $new_value 	= $this->checkOvertimeHoliday(date('d-m', strtotime($value)));

                    // 	$tmp[$new_key] = $new_value;
                    // }

                    $tmp[$key] = $value;
                }
            }
           array_push($data, $tmp);
        }

        return Excel::create('overtime_request_'.date('Ymdhis'), function($excel) use ($data, $array_title) {
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
            	
                $tmp_array[$title_key] = $data_value[$title_key];
            }

            array_push($result, $tmp_array);
        }

        return $result;
    }

    private function checkOvertimeTypes($type) {

        $arr_overtime_types   	= Config::get('overtime_types');
        $count                  = count($arr_overtime_types);

        for ($i = 0; $i< $count; $i++) {
            if ($type == $i) {

                $type = $arr_overtime_types[$i];
            }
        }

        return $type;
    }

    // private function checkOvertimeHoliday($date) {

    // 	$arr_overtime_holiday   	= Config::get('holiday');

    //     foreach ($arr_overtime_holiday as $key => $value) {

    //     	if ($key == $date) {

    //     		$date = $value;
    //     	} else {

    //     		$date = '';
    //     	}
    //     }

    //     return $date;
    // }

    private function checkStatusApprove($status) {

        if ($status == 0) {

            $status = Lang::get('admin/overtime.not_approved');
        } else if ($status == 1) {

            $status = Lang::get('admin/overtime.approved');
        } else if ($status == 2) {

            $status = Lang::get('admin/overtime.reject');
        }

        return $status;
    }


	//start UserController
	public function addOvertime(){
    	$employeeId = Input::get('employeeId');
    	$date 		= Input::get('date');
    	$startTime 	= $date.' '.Input::get('startTime');
    	$endTime 	= $date.' '.Input::get('endTime');
    	$approverId = Input::get('approverId');
    	$typeId 	= Input::get('typeId');
    	$note 		= Input::get('note');
    	// unset($data['_token']);
    	$data=[
    	'employeeId'=>$employeeId,
    	'date'		=>$date,
    	'startTime'	=>$startTime,
    	'endTime'	=>$endTime,
    	'approverId'=>$approverId,
    	'typeId'	=>$typeId,
    	'note'		=>$note
    	];

        $this->overtime->addOvertime($data);
    }

	public function GetAll_front($paginate = PAGINATE_TRUE) {

		$where 				= array();
		$endDate 			= Input::get('endDate');
		// $approve 			= Input::get('slc_approve');
		$startDate 			= Input::get('startDate');
		// $department 		= Input::get('slc_department');
		// $employeeName 		= Input::get('employeeName');
		$emp_id				= Auth::user()->id;

		if (!empty($startDate)) {
			$tmp = array (
					'fields' 		=> 'overtime.date',
					'operator'		=> '>=',
					'value' 		=> $startDate . ' ' . '00:00:00'
				);

			array_push($where, $tmp);
		}

		if (!empty($endDate)) {
			$tmp = array (
					'fields' 		=> 'overtime.date',
					'operator' 		=> '<=',
					'value' 		=> $endDate . ' ' . '23:59:59'
				);

			array_push($where, $tmp);
		}

		// echo "<pre>";
		// print_r($where);
		// exit;

		if ($paginate == true) {
			$emp_id = Auth::user()->id;
			$data = Overtime::Search_front($where, $emp_id);
		} else {
			$data = Overtime::Search_front($where, $emp_id, false);
		}


		$data = $this->format_date($data);

		$data['extra']['search_startDate'] 	= $startDate;
		$data['extra']['search_endDate'] 	= $endDate;
		$data['extra']['search_where'] 		= $where;

		return $data;

	}

	public function format_date($data){
		foreach ($data['response'] as $key => $value) {
			$tmp_startTime 	= strtotime($value->startTime);
			$tmp_endTime 	= strtotime($value->endTime);

			$value->startTime 	= date("H:i", $tmp_startTime);
			$value->endTime 	= date("H:i", $tmp_endTime);
			switch ($value->typeId) {
					case '0':
						$value->typeId = Lang::get('user/overtime_report.type_OT_0');
						break;

					case '1':
						$value->typeId = Lang::get('user/overtime_report.type_OT_1');
						break;

					case '2':
						$value->typeId = Lang::get('user/overtime_report.type_OT_2');
						break;

					case '3':
						$value->typeId = Lang::get('user/overtime_report.type_OT_3');
						break;

					case '4':
						$value->typeId = Lang::get('user/overtime_report.type_OT_4');
						break;

					case '5':
						$value->typeId = Lang::get('user/overtime_report.type_OT_5');
						break;

					case '6':
						$value->typeId = Lang::get('user/overtime_report.type_OT_6');
						break;

					case '7':
						$value->typeId = Lang::get('user/overtime_report.type_OT_7');
						break;

					case '8':
						$value->typeId = Lang::get('user/overtime_report.type_OT_8');
						break;
				}

				switch ($value->approverId) {
					case '1':
						$value->approverId = Lang::get('user/overtime_report.approverId_1');
						break;

					case '2':
						$value->approverId = Lang::get('user/overtime_report.approverId_2');
						break;

					case '3':
						$value->approverId = Lang::get('user/overtime_report.approverId_3');
						break;

					default:
						# code...
						break;
				}
			}
		return $data;
	}


    public function exportOvertime(){
        $result = $this->GetAll_front(PAGINATE_FALSE);
        $data = array();

        foreach ($result['response'] as $key => $value) {
           $tmp = array();
           foreach ($value as $k => $v) {
               $tmp[$k] = $v;
           }
           array_push($data, $tmp);
        }

        return Excel::create('OverTime_Data_'.date('Y_m_d_h_i_s'), function($excel) use ($data) {
           $excel->sheet('mySheet', function($sheet) use ($data)
           {
               $sheet->fromArray($data, null, 'A1', false, false);
               $sheet->prependRow(1, array(
               	Lang::get('user/overtime_report.em_id'),
               	Lang::get('user/overtime_report.date'),
               	Lang::get('user/overtime_report.start_time'),
               	Lang::get('user/overtime_report.end_time'),
               	Lang::get('user/overtime_report.department'),
               	Lang::get('user/overtime_report.working_type'),
               	Lang::get('user/overtime_report.note'),
               	Lang::get('user/overtime_report.approver'),
               	Lang::get('user/overtime_report.approved_date')));
           });
       })->download('xlsx');
    }
	//End UserController

}