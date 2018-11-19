<?php
namespace Spr\Base\Models;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use Spr\Base\Response\Response;
use DB;
use Config;
class Helper extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $timestamps = false;


	public function __construct(){


		// $this->now = \Carbon\Carbon::now()->toDateTimeString();
	}

	public static function insert ( $table, $data, $where = array()) {
		$Response = new Response();
		$results = $Response->response(200,'','',true);

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

			$query->insert($data);

		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function insertGetId ( $table, $data, $where = array()) {
		$Response = new Response();
		$results = $Response->response(200,'','',true);

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

			$results['response'] = $query->insertGetId($data);
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function update_db ( $table, $data, $where) {
		$Response = new Response();
		$results = $Response->response(200,'','',true);

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
			$querry = $query->update($data);
			// $queries = DB::getQueryLog();
			// $last_query = end($queries);
			// print_r($last_query);
			// exit;
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function select ( $table, $where = array(), $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {
		$Response = new Response();
		$results = $Response->response(200,'','',true);

		try {
			$query = DB::table($table)->select();

			foreach ($where as $key => $value) {

				switch ($value['operator']) {
					case 'in':
						$query = $query->whereIn($value['fields'], $value['value']);
						break;
					case 'null':
						$query = $query->whereNull($value['fields']);
						break;
					case 'raw':
						$query = $query->whereRaw($value['sql']);
						break;
					default:
						$query = $query->where($value['fields'], $value['operator'], $value['value']);
						break;
				}
			}

			if(!is_null($limit)  && !is_null($offset) && $selectType != Config::get('spr.system.type.query.paginate')){
				$query = $query->take($limit)->skip($offset);
			}
			if($order !== null) {

				foreach ($order as $key => $value) {

					if($value['fields'] != ''){
						$query = $query->orderBy($value['fields'],$value['operator']);
					}
				}
			}

			DB::enableQueryLog();

			switch ($selectType) {
				case Config::get('spr.system.type.query.count'):
				// DB::enableQueryLog();
					$query = $query->count();
					break;
				case Config::get('spr.system.type.query.max'):
					$query = $query->max($fields);
					break;
				case Config::get('spr.system.type.query.min'):
					$query = $query->min($fields);
					break;
				case Config::get('spr.system.type.query.paginate'):

					$query = $query->paginate($limit);
					break;
				default :
					$query = $query->get();
					break;
			}
			// $queries = DB::getQueryLog();
			// 	$last_query = end($queries);
			// 	print_r($last_query);
				// exit;
			$results['response'] = $query;
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['code'] = 401;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function decrementData ($table, $where, $data) {

		$Response = new Response();
		$results = $Response->response(200,'','',true);

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

			$querry = $query->decrement($data['fields'],$data['value']);

		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function incrementData ($table, $where, $data) {

		$Response = new Response();
		$results = $Response->response(200,'','',true);

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

			$querry = $query->increment($data['fields'],$data['value']);

		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public static function get_SUM_data ($table, $where, $column) {
		$Response = new Response();
		$results = $Response->response(200,'','',true);

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

			$query = $query->sum($column);
			$results['response'] = $query;
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

}
