<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Response\Response;
use Config;
use Session;
use Lang;
// use PDOException;

class Employee extends Base
{
	protected $table = "employee";
    public $timestamps = false;

    public function employeeInfo() {

        $users = DB::table('employee_role_relationship')
            ->join('employee', 'employee_role_relationship.employeeId', '=', 'employee.id')
            ->join('role', 'employee_role_relationship.roleId', '=', 'role.id')
            ->select('role.name')
            ->get();

            return $users;

            // print_r($users);
            // exit();

    }

    public function addEmployee($data) {

        try {

            $this->insert($this->table,$data);
            $results = Response::response(200, '', $data, true);
            Session::flash('success', Lang::get('admin/register.register_success'));
        } catch (Exception $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }
    }//end employee Model

    public function checkExist($column,$val) {

        $flag = false;
        $query = DB::table($this->table) -> select('id')->where($column,'=',$val)->get();

        if( count($query) > 0 ){

            $flag = true;
        }

        return $flag;
    }

    public static function Search($where = array(), $paginate = true) {

        try {

            $query = DB::table('employee as e')->select('e.id',
                                                    'e.firstname',
                                                    'e.lastname',
                                                    'e.employeeCode',
                                                    'e.displayName',
                                                    'e.email',
                                                    'e.gender',
                                                    'e.birthday',
                                                    'e.address1',
                                                    'e.address2',
                                                    'e.phone_number',
                                                    'e.probationary',
                                                    'e.official_date',
                                                    'e.out_date',
                                                    'e.position',
                                                    'e.managerId',
                                                    'e.departmentId',
                                                    'e.diplomaId',
                                                    'e.active',
                                                    'e.description',
                                                    'e.avatar_name',
                                                    'e.avatar_path',
                                                    'e.holiday_allowance',
                                                    'e.createdById',
                                                    'e.is_manager'
                                                    // 'employee_rr.id as employee_role_relationship_id'
                                                );
            // $query->join('employee_role_relationship as employee_rr', 'employee_rr.employeeId', '=', 'e.id');

            foreach ($where as $key => $value) {

                switch ($value['operator']) {

                    case 'in':
                        $query = $query->whereIn($value['fields'], $value['value']);
                        break;

                    case 'null':
                        $query = $query->whereNull($value['fields']);
                        break;
                    case 'raw':
                        $query = $query->whereRaw($value['value']);
                        break;
                    default:
                        $query = $query->where($value['fields'], $value['operator'], $value['value']);
                        break;
                }
            }

            $query->orderBy('e.out_date', 'desc');

            if($paginate) {

                $data = $query->paginate(Config::get('mycnf.paginate'));
            } else {

                $data = $query->get();
            }

            $results    = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
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
            $results['meta']['msg']     = $e->getMessage();

            Session::flash('message_fail', 'Update fail!');
            Session::flash('alert-class', 'alert-danger');
        }

        return $results;
    }

    // public function increaseEmpCode() {
    //     $query = DB::table
    // }
}
