<?php

namespace App\Http\Models;

use App\Http\Response\Response;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use Auth;
use Lang;


class LeaveRequest extends Base
{
	protected $table = 'holiday';

	public static function Search($where = array(), $paginate = true, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

        try {

            $query =  DB::table('employee')
                        ->select('employee.id as employee_id',
                                    'employee.firstname',
                                    'employee.lastname',
                                    'employee.employeeCode',
                                    'employee.email',
                                    'holiday.id as holiday_id',
                                    'holiday.employeeId',
                                    'holiday.start_date',
                                    'holiday.end_date',
                                    'holiday.types',
                                    'holiday.isApproved',
                                    'holiday.approvedDate',
                                    'holiday.note',
                                    'department.id',
                                    'emp.firstname as approver_firstname',
	                    			'emp.lastname as approver_lastname'
                                )
                        ->join('holiday', 'employee.id', '=', 'holiday.employeeId')
                        ->join('department', 'department.id', '=', 'employee.departmentId')
                        ->join('employee as emp', 'emp.id', '=', 'holiday.approverId');

            foreach ($where as $key => $value) {

                switch ($value['operator']) {

                    case 'in':
                        $query = $query->whereIn($value['fields'], $value['value']);
                        break;

                    case 'null':
                        $query = $query->whereNull($value['fields']);
                        break;

                    default:
                        $query = $query->where($value['fields'], $value['operator'], $value['value']);
                        break;
                }
            }

            $query->orderBy('holiday.start_date', 'desc')
                    ->orderBy('employee.employeeCode');

            if($paginate) {

                $data = $query->paginate(Config::get('mycnf.paginate'));
            } else {

                $data = $query->get();
            }

            $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }

    public static function Search_front($where = array(),$emp_id, $paginate = true, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

        try {

            $query =  DB::table('employee')
                        ->select('employee.id as employee_id',
                                    'holiday.start_date',
                                    'holiday.id as holiday_id',
                                    'holiday.end_date',
                                    'holiday.types',
                                    'holiday.approverId',
                                    'holiday.approvedDate',
                                    'holiday.isApproved',
                                    'holiday.note')
                        ->join('holiday', 'employee.id', '=', 'holiday.employeeId')
                        ->join('employee as emp', 'emp.id', '=', 'holiday.approverId');

            foreach ($where as $key => $value) {

                switch ($value['operator']) {

                    case 'in':
                        $query = $query->whereIn($value['fields'], $value['value']);
                        break;

                    case 'null':
                        $query = $query->whereNull($value['fields']);
                        break;

                    default:
                        $query = $query->where($value['fields'], $value['operator'], $value['value']);
                        break;
                }
            }

            $query  ->orderBy('holiday.start_date', 'desc')
                    ->orderBy('holiday.end_date', 'desc')
                    ->where('employee.id','=',$emp_id);

            if($paginate) {

                $data = $query->paginate(Config::get('mycnf.paginate'));
            } else {

                $data = $query->get();
            }

            // echo "<pre>";
            // print_r($data);
            // exit;

            $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }


    public static function UpdateData($table, $data, $where) {

		try {

            $query = DB::table($table);

            foreach ($where as $key => $value) {

                switch ($value['operator']) {

                    case 'in':
                        $query = $query->whereIn($value['fields'], $value['value']);
                        break;

                    case 'null':
                        $query = $query->whereNull($value['fields']);
                        break;

                    default:
                        $query = $query->where($value['fields'], $value['operator'], $value['value']);
                        break;
                }
            }

            // DB::enableQueryLog();
            $query->update($data);

            $results = Response::response(200, '', $data, true);

			Session::flash('message_success', 'Update successful!');
			Session::flash('alert-class', 'alert-success');

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg'] 	= $e->getMessage();

			Session::flash('message_fail', 'Update fail!');
			Session::flash('alert-class', 'alert-danger');
        }

        return $results;
	}
    public function searchByDate($where = array(),$export=false, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null){

        $query =  DB::table($this->table)->orderBy('id', 'desc');

        foreach ($where as $key => $value) {

            switch ($value['operator']) {
                case 'in':
                    $query = $query->whereIn($value['fields'], $value['value']);
                    break;
                case 'null':
                    $query = $query->whereNull($value['fields']);
                    break;
                default:
                    $query = $query->where($value['fields'], $value['operator'], $value['value']);
                    break;
            }
        }
        if($export==true){
            $data = $query->get();
        }
        else
        {
            $pages=Config::get('mycnf.paginate');
            $data = $query->paginate($pages);
        }
        return $data;
    }




    public static function GetDepartment() {

        try {

            $query   = DB::table('department')->select('id', 'name', 'phone_number', 'address')
                                              ->orderBy('name');

            $data    = $query->get();

            $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }
    public function addLeaveRequest($data){
        try {
            $this->insert($this->table,$data);
            $results = Response::response(200, '', $data, true);
            Session::flash('success', Lang::get('user/leave_request.success'));
            Session::flash('alert-class', 'alert-success');
        } catch (Exception $e) {
            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
            Session::flash('message_fail', Lang::get('user/leave_request.failed'));
            Session::flash('alert-class', 'alert-danger');
        }
    }
}