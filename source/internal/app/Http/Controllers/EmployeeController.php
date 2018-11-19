<?php
namespace App\Http\Controllers;

use App\Http\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Config;
use Input;
use Lang;

class EmployeeController extends Controller
{
	public function GetResignedEmployee() {

		$where 							= array();
        $startDate_official_date       	= Input::get('search_startDate_official_date');
		$endDate_official_date        	= Input::get('search_endDate_official_date');
		$startDate_out_date 			= Input::get('search_startDate_out_date');
		$endDate_out_date            	= Input::get('search_endDate_out_date');
        $employeeName       			= Input::get('employeeName');

		$tmp = array (
                'fields'        => 'e.active',
                'operator'      => '=',
                'value'         => '0'
            );

        array_push($where, $tmp);

        // if (!empty($employeeName)) {

        //     $tmp = array (
        //             'fields'        => 'e.displayName',
        //             'operator'      => 'LIKE',
        //             'value'         => '%' . $employeeName . '%'
        //         );

        //     array_push($where, $tmp);
        // }

        if (!empty($employeeName)) {

        	$tmp = $this->format_where_condition('e.displayName', 'LIKE', '%' . $employeeName . '%');
        	array_push($where, $tmp);
        }

        if (!empty($startDate_official_date)) {

        	$tmp = $this->format_where_condition('e.official_date', '>=', $startDate_official_date . ' ' . '00:00:00');
        	array_push($where, $tmp);
        }

        if (!empty($endDate_official_date)) {

        	$tmp = $this->format_where_condition('e.official_date', '<=', $endDate_official_date . ' '  . '23:59:59');
        	array_push($where, $tmp);
        }

        if (!empty($startDate_out_date)) {

        	$tmp = $this->format_where_condition('e.out_date', '>=', $startDate_out_date . ' '  . '00:00:00');
        	array_push($where, $tmp);
        }

        if (!empty($endDate_out_date)) {

        	$tmp = $this->format_where_condition('e.out_date', '<=', $endDate_out_date . ' '  . '23:59:59');
        	array_push($where, $tmp);
        }

		$data = Employee::Search($where);

		$data['extra']['search_startDate_official_date']  = $startDate_official_date;
        $data['extra']['search_endDate_official_date']    = $endDate_official_date;
        $data['extra']['search_startDate_out_date']  = $startDate_out_date;
        $data['extra']['search_endDate_out_date']    = $endDate_out_date;
        $data['extra']['search_empName']    = $employeeName;
        $data['extra']['search_where']      = $where;

		return $data;
	}

    public function GetWorkingEmployee() {

        $where                          = array();
        $startDate_official_date        = Input::get('search_startDate_official_date');
        $endDate_official_date          = Input::get('search_endDate_official_date');
        $startDate_out_date             = Input::get('search_startDate_out_date');
        $endDate_out_date               = Input::get('search_endDate_out_date');
        $employeeName                   = Input::get('employeeName');

        $tmp = array (
                'fields'        => 'e.active',
                'operator'      => '=',
                'value'         => '1'
            );

        array_push($where, $tmp);

        if (!empty($employeeName)) {

            $tmp = $this->format_where_condition('e.displayName', 'LIKE', '%' . $employeeName . '%');
            array_push($where, $tmp);
        }

        if (!empty($startDate_official_date)) {

            $tmp = $this->format_where_condition('e.official_date', '>=', $startDate_official_date . ' ' . '00:00:00');
            array_push($where, $tmp);
        }

        if (!empty($endDate_official_date)) {

            $tmp = $this->format_where_condition('e.official_date', '<=', $endDate_official_date . ' '  . '23:59:59');
            array_push($where, $tmp);
        }

        $data = Employee::Search($where);

        $data['extra']['search_startDate_official_date']  = $startDate_official_date;
        $data['extra']['search_endDate_official_date']    = $endDate_official_date;
        $data['extra']['search_startDate_out_date']  = $startDate_out_date;
        $data['extra']['search_endDate_out_date']    = $endDate_out_date;
        $data['extra']['search_empName']    = $employeeName;
        $data['extra']['search_where']      = $where;

        return $data;
    }


    public function GetOneEmp() {

        $id         = Input::get('id');

        $where = [
            [
                'fields'        => 'e.id',
                'operator'      => '=',
                'value'         => $id
            ]
        ];

        $data = Employee::Search($where);

        return $data;
    }


    public function Update() {

        try {

            $id                 = Input::get('id');
            $firstname          = Input::get('firstname');
            $lastname           = Input::get('lastname');
            $birthday           = Input::get('birthday');
            $gender             = Input::get('gender');
            $address            = Input::get('address');
            $phone_number       = Input::get('digits');
            $probationary       = Input::get('probationary');
            $official_date      = Input::get('official_date');
            $position           = Input::get('position');
            $department         = Input::get('department');

            if ($this->CheckValidDate($birthday) == null || $this->CheckValidDate($probationary) == null || $this->CheckValidDate($probationary) == null || $this->CheckValidDate($official_date) == null) {
                return false;
            }

            $data = [
                'id'                => $id,
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'birthday'          => $birthday,
                'gender'            => $gender,
                'address1'          => $address,
                'phone_number'      => $phone_number,
                'probationary'      => $probationary,
                'official_date'     => $official_date,
                'position'          => $position,
                'departmentId'      => $department,
            ];

            $where = [
                [
                    'fields'        => 'id',
                    'operator'      => '=',
                    'value'         => $id
                ]
            ];

            $data = Employee::UpdateData('employee', $data, $where);

            $results = Response::response(200, '', $data);

        } catch (Exception $e) {

            $results['meta']['success'] = false;
            $results['meta']['code'] = 401;
            $results['meta']['msg'] = $e->getMessage();
        }

        return $results;
    }

    private function CheckValidDate($date) {

        $timestamp = strtotime($date);

        return $timestamp ? $date : null;
    }


    public function format_where_condition($fields = null, $operator = null, $value = null) {

        return [
            'fields'        => $fields,
            'operator'      => $operator,
            'value'         => $value
        ];
    }
}