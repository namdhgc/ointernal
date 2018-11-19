<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Config;
use Session;
use Lang;
use PDOException;

/**
*
*/
class Overtime extends Base
{
	protected $table='overtime';
	function __construct()
	{
		# code...
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


	public static function Search($where = array(), $paginate = true, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

		try {

			$query =  DB::table('employee')
	                    ->select('employee.id as employee_id',
	                    			'employee.firstname',
	                    			'employee.lastname',
	                    			'employee.employeeCode',
	                    			'employee.email',
	                    			'employee.roleId',
	                    			'overtime.id as overtime_id',
	                    			'overtime.date',
	                    			'overtime.note',
	                    			'overtime.startTime',
	                    			'overtime.endTime',
	                    			'overtime.approverId',
	                    			'overtime.typeId',
	                    			'overtime.approvedDate',
	                    			'overtime.isApproved',
	                    			'overtime.updated_at',
	                    			'department.id as department_id',
	                    			'department.name',
	                    			'emp.firstname as approver_firstname',
	                    			'emp.lastname as approver_lastname'
	                    		)
	                    ->join('overtime', 'employee.id', '=', 'overtime.employeeId')
	        			->join('department', 'department.id', '=', 'employee.departmentId')
	        			->join('employee as emp', 'overtime.approverId', '=', 'emp.id');

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

	        $query->orderBy('overtime.date', 'desc')
	        		->orderBy('employee.employeeCode');

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
            $results['meta']['code'] 	= 401;
            $results['meta']['msg'] 	= $e->getMessage();
		}

        return $results;
	}


	public static function GetDepartment() {

		try {

			$query = DB::table('department')->select('id', 'name', 'phone_number', 'address');
			$query->orderBy('name');

			$data = $query->get();

			$results = Response::response(200, '', $data);

		} catch (PDOException $e) {

			$results['meta']['success'] = false;
            $results['meta']['code'] = 401;
            $results['meta']['msg'] = $e->getMessage();
		}

		return $results;
	}






	//User Model
	public static function Search_front($where = array(),$emp_id, $paginate = true, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

		try {

			$query =  DB::table('employee')
	                    ->select('employee.id as employee_id',
	                    			'overtime.date',
	                    			'overtime.startTime',
	                    			'overtime.endTime',
	                    			'department.name',
	                    			'overtime.typeId',
	                    			'overtime.note',
	                    			'overtime.approverId',
	                    			'overtime.isApproved',
	                    			'overtime.approvedDate')
	                    ->join('overtime', 'employee.id', '=', 'overtime.employeeId')
	        			->join('department', 'department.id', '=', 'employee.departmentId')
	        			->join('employee as emp', 'overtime.approverId', '=', 'emp.id')->orderBy('employee_id', 'desc');

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

	        $query 	->orderBy('overtime.date', 'desc')
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
            $results['meta']['code'] 	= 401;
            $results['meta']['msg'] 	= $e->getMessage();
		}

        return $results;
	}

    public function addOvertime($data){
    	try {
    		$this->insert($this->table,$data);
            $results = Response::response(200, '', $data, true);
            Session::flash('success', Lang::get('user/overtime_log.success'));
    	} catch (Exception $e) {
    		$results['meta']['success'] = false;
            $results['meta']['msg'] 	= $e->getMessage();
    	}
    }//end user Model
}