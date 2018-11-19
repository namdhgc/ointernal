<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Config;
use Session;
use Lang;
// use PDOException;

class Summary extends Base
{
	public static function Search_2($where = array(), $paginate = true, $admin = false, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

		try {
			DB::enableQueryLog();

			$query = DB::table('employee as e')
					->select('e.employeeCode',
								'e.firstname',
								'e.lastname',
								'e.departmentId',
								'd.name as department_name'
							);

			$query->addSelect(
								DB::raw("(SELECT
										    SEC_TO_TIME(
										      SUM(
										        TIME_TO_SEC(o.`endTime`) - TIME_TO_SEC(o.`startTime`)
										      )
										    )
										  FROM
										    overtime AS o
										  WHERE
										    o.employeeId = e.id
										  AND
										  	isApproved = '1'
										) AS total_accepted_overtime")
							);

			$query->addSelect(
								DB::raw('(SELECT
										  SEC_TO_TIME(
										    SUM(
										      TIME_TO_SEC(w.`endDate`) - TIME_TO_SEC(w.`startDate`)
										    )
										  )
										FROM
										  workingtime AS w
										WHERE
										  w.employeeId = e.id
										) AS total_workingtime')
							);

			$query->addSelect(
								DB::raw("(SELECT COUNT(id) FROM holiday AS h WHERE h.employeeId = e.id AND h.isApproved = 1) AS approved_holiday")
							);

			$query->addSelect(
								DB::raw("(SELECT COUNT(id) FROM holiday AS h WHERE h.employeeId = e.id AND h.isApproved = 0) AS not_approve_holiday")
							);

			$query->leftJoin('workingtime as w', 'e.id', '=', 'w.employeeId')
					->leftJoin('overtime as o', 'e.id', '=', 'o.employeeId')
                    ->leftJoin('department as d', 'd.id', '=', 'e.departmentId')
        			->groupBy('e.employeeCode')
        			->groupBy('e.firstname')
        			->groupBy('e.lastname')
        			->groupBy('e.departmentId')
        			->groupBy('e.id')
        			->groupBy('d.name')
        			->groupBy('d.id');


	        foreach ($where as $key => $value) {

	            switch ($value['operator']) {

	                case 'in':
	                    $query = $query->whereIn($value['fields'], $value['value']);
	                    break;

	                case 'null':
	                    $query = $query->whereNull($value['fields']);
	                    break;

	                default:

	                	if ($admin) {

	                		//search in Admin

	                			$query = $query->where($value['fields'], $value['operator'], $value['value']);


	                	} else {
	                		// search in user
	                		if ($value['fields'] == 'summary_date_up' || $value['fields'] == 'summary_date_down') {

	                			$query->addSelect(
													DB::raw("(SELECT
															    SEC_TO_TIME(
															      SUM(
															        TIME_TO_SEC(o.`endTime`) - TIME_TO_SEC(o.`startTime`)
															      )
															    )
															  FROM
															    overtime AS o
															  WHERE
															    o.employeeId = e.id
															  AND
															  	isApproved = '1' AND "
															  	. " (w.date " . $value['operator'] . "'" . $value['value'] . "'" . " AND o.date " . $value['operator'] . "'" . $value['value'] . "')" .
															") AS total_accepted_overtime")
												);

								$query->addSelect(
													DB::raw("(SELECT
															  SEC_TO_TIME(
															    SUM(
															      TIME_TO_SEC(w.`endDate`) - TIME_TO_SEC(w.`startDate`)
															    )
															  )
															FROM
															  workingtime AS w
															WHERE
															  w.employeeId = e.id AND "
															  . " (w.date " . $value['operator'] . "'" . $value['value'] . "'" . " AND o.date " . $value['operator'] . "'" . $value['value'] . "')" .
															" ) AS total_workingtime")
												);

	                			$query = $query->whereRaw(" (w.date " . $value['operator'] . "'" . $value['value'] . "'" . " OR o.date " . $value['operator'] . "'" . $value['value'] . "')");
	                		} else {

	                			$query->addSelect(
													DB::raw("(SELECT
															    SEC_TO_TIME(
															      SUM(
															        TIME_TO_SEC(o.`endTime`) - TIME_TO_SEC(o.`startTime`)
															      )
															    )
															  FROM
															    overtime AS o
															  WHERE
															    o.employeeId = e.id
															  AND
															  	isApproved = '1'
															) AS total_accepted_overtime")
												);

								$query->addSelect(
													DB::raw('(SELECT
															  SEC_TO_TIME(
															    SUM(
															      TIME_TO_SEC(w.`endDate`) - TIME_TO_SEC(w.`startDate`)
															    )
															  )
															FROM
															  workingtime AS w
															WHERE
															  w.employeeId = e.id
															) AS total_workingtime')
												);

	                			$query = $query->where($value['fields'], $value['operator'], $value['value']);
	                		}
	                	}


	                    break;
	            }
	        }

	        $query->orderBy('e.employeeCode');

		  	if($paginate) {

		  		$data = $query->paginate(Config::get('mycnf.paginate'));
		  	} else {

		  		$data = $query->get();
		  	}

		  	// echo "<pre>";
		  	// print_r($data);
		  	// exit;
		  	// dd(DB::getQueryLog());

	        $results = Response::response(200, '', $data);

		} catch (PDOException $e) {

			$results['meta']['success'] = false;
            $results['meta']['code'] 	= 401;
            $results['meta']['msg'] 	= $e->getMessage();
		}

        return $results;
	}

	public static function Search ($key = null , $startTime = null, $endTime = null,  $employeeId = null, $department = null, $approve = null, $offset = null) {

		try {
            DB::enableQueryLog();

            $where_raw_time_working_time 	= '';
            $where_raw_time_over_time 		= '';
            $where_raw_time_holiday 		= '';

            if( $startTime != null && $startTime != ''){

            	$where_raw_time_working_time .= 'w.startDate >= "' .$startTime . ' ' . '00:00:00" ';
            	$where_raw_time_over_time 	 .= 'o.startTime >= "' .$startTime . ' ' . '00:00:00" ';
            	$where_raw_time_holiday 	 .= ' AND h.start_date >= "' .$startTime . ' ' . '00:00:00" ';
            }

            if( $endTime != null && $endTime != '' ){

            	if($where_raw_time_working_time != '') $where_raw_time_working_time .= ' AND ';
            	if($where_raw_time_over_time != '') $where_raw_time_over_time .= ' AND ';

            	$where_raw_time_working_time .= 'w.endDate <= "' .$endTime . ' ' . '23:59:59" ';
            	$where_raw_time_over_time 	 .= 'o.endTime <= "' .$endTime . ' ' . '23:59:59" ';
            	$where_raw_time_holiday 	 .= ' AND h.end_date <= "' .$endTime . ' ' . '23:59:59" ';
            }

            // if( $approve != null && $approve != '' ){

            // 	if($where_raw_time_over_time != '') $where_raw_time_over_time .= ' AND ';

            // 	$where_raw_time_over_time 	 .= 'o.isApproved = ' .$approve ;
            // }

            if($where_raw_time_working_time != '') $where_raw_time_working_time = 'AND '.$where_raw_time_working_time;
            if($where_raw_time_over_time != '') $where_raw_time_over_time = 'AND '.$where_raw_time_over_time;

            $query = DB::table('employee as e')->select(['e.employeeCode',
														'e.firstname',
														'e.lastname',
														'e.departmentId',
														'd.name as department_name',
														'p.name as position_name',
														DB::Raw('
															(SELECT SEC_TO_TIME(SUM(( UNIX_TIMESTAMP(o.`endTime`) - UNIX_TIMESTAMP(o.`startTime`)))) FROM overtime as o WHERE o.employeeId = e.id AND o.isApproved = 1 '.$where_raw_time_over_time.' ) AS total_accepted_overtime,
															(SELECT SEC_TO_TIME(SUM(( UNIX_TIMESTAMP(w.`endDate`) - UNIX_TIMESTAMP(w.`startDate`)))) FROM workingtime  as w WHERE w.employeeId = e.id '.$where_raw_time_working_time.' ) AS total_workingtime,
															(SELECT COUNT(id) FROM holiday AS h WHERE h.employeeId = e.id AND h.isApproved = 1 ' . $where_raw_time_holiday . ') AS approved_holiday,
															(SELECT COUNT(id) FROM holiday AS h WHERE h.employeeId = e.id AND h.isApproved = 0 ' . $where_raw_time_holiday . ') AS not_approve_holiday
														')
													])
           										->leftJoin('workingtime as w', 'w.employeeId', '=', 'e.id')
           										->leftJoin('overtime as o', 'o.employeeId', '=', 'e.id')
           										->leftJoin('department as d', 'd.id', '=', 'e.departmentId')
           										->leftJoin('position as p', 'p.positionId', '=', 'e.position');

            if( $key != null && $key != '' ){

            	$query = $query->where('e.displayName','like','%'.$key.'%');
            }

            if( $employeeId != null && $employeeId != '' ){

            	$query = $query->where('e.id','=',$employeeId);
            }

            if( $department != null && $department != '' ){

            	$query = $query->where('e.departmentId','=',$department);
            }
            $query->groupBy('e.employeeCode');
            $query->orderBy('e.employeeCode');

		  	if($offset != null && $offset != '') {

		  		$data = $query->paginate($offset);
		  	} else {

		  		$data = $query->get();
		  	}

		  	// echo "<pre>";
		  	// print_r($data);
		  	// exit;
		  	// dd(DB::getQueryLog());
		  	// dd($data);

	        $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg'] 	= $e->getMessage();
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
}