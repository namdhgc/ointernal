<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Response\Response;
use Config;
use Session;
use Lang;
use PDOException;

class EmployeeRoleRelationship extends Base
{
	protected $table = "employee_role_relationship";
    public $timestamps = false;

    public function get_data_by_employee_id($employeeId){

        $query = DB::table($this->table)
            ->where('employeeId','=', $employeeId)
            ->first();
        return $query;

    }
    // $employeeid = DB::table('employee_role_relationship')
    //         ->join('employee', 'employee_role_relationship.employeeId', '=', 'employee.id')
    //         ->select('employee_role_relationship.employeeId','employee_role_relationship.roleId')
    //         ->get();
    //         return $users;

    public function addRole($data){

        try {

            $this->insert($this->table,$data);
            $results = Response::response(200, '', $data, true);
            Session::flash('success', Lang::get('admin/register.register_success'));
        } catch (Exception $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }
    }
}