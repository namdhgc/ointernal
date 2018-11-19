<?php

namespace App\Http\Models;

use App\Http\Response\Response;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use Auth;
use Lang;
class Timesheet extends Base
{
    protected $table='workingtime';


    // start admin model

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

        } catch (\PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();

            Session::flash('message_fail', 'Update fail!');
            Session::flash('alert-class', 'alert-danger');
        }

        return $results;
    }


    public static function Search($where = array(), $paginate = true, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

        try {

            $query =  DB::table('employee')
                        ->select('employee.id',
                                    'employee.firstname',
                                    'employee.lastname',
                                    'employee.employeeCode',
                                    'workingtime.id',
                                    'workingtime.employeeId',
                                    'workingtime.date',
                                    'workingtime.startDate',
                                    'workingtime.endDate',
                                    'workingtime.note',
                                    'workingtime.totalTimePerDay',
                                    'workingtime.totalTimePerMonth'
                                )
                        ->join('workingtime', 'employee.id', '=', 'workingtime.employeeId')
                        ->join('department', 'department.id', '=', 'employee.departmentId');

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

            $query->orderBy('employee.employeeCode')
                    ->orderBy('workingtime.date', 'desc');

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

    //end admin model

    // start user model
    public function getInformRecent($emp_id){
        $pages  = Config::get('mycnf.paginate');
        $rs     = DB::table($this->table)->where('employeeId',$emp_id)
                                         ->orderBy('id', 'desc')
                                         ->paginate($pages);
        return $rs;
    }

    public function getInformChart($emp_id){
        $rs = DB::table($this->table)->where('employeeId',$emp_id)
                                     ->orderBy('id', 'desc')
                                     ->get();
        return $rs;
    }

    public function getNewestDate($emp_id){
        $rs = DB::table($this->table)->where('employeeId',$emp_id)
                                     ->orderBy('id', 'desc')->first();
        return $rs;
    }

    public function getInfoByDate($emp_id,$firstDate,$lastDate){
        $rs = DB::table($this->table)->where('employeeId',$emp_id)
                                     ->where('date','>=',$firstDate)
                                     ->where('date','<=',$lastDate)
                                     ->get();
        return $rs;
    }

    public function addTimesheet($timesheet){
        try
        {
            $this->insert($this->table,$timesheet);
            $results = Response::response();
            Session::flash('success', Lang::get('user/timesheet_log.success'));
        } catch (PDOException $e) {
            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
        }
        return $results;

    }

    public function updateTimesheet($id,$checkout){
        try {
            $this->update($this->table,$id,$checkout);
            $results = Response::response();
            Session::flash('success', Lang::get('user/timesheet_log.success'));
        } catch (Exception $e) {
            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
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
            $pages= Config::get('mycnf.paginate');
            $data = $query->paginate($pages);
        }
        return $data;
    }

    //Get date and end date for check in and check out
    public function statusCheckIn()
    {
        $checkedin  = false;
        $query      = DB::table($this->table)->where('date','=',date('Y-m-d'))
                                             ->where ('employeeId', '=', Auth::user()->id)
                                             ->get();
        if (count($query)>0) {
            $checkedin = true;
        }
        return $checkedin;
    }

    public function statusCheckOut()
    {
        $checkedout = false;
        $query      = DB::table($this->table)->whereNull('endDate')
                                             ->where('date','=',date('Y-m-d'))
                                             ->where('employeeId','=',Auth::user()->id)
                                             ->get();
        if (count($query) > 0) {
            $checkedout = true;
        }
        return $checkedout;
    }
    // end user model
}