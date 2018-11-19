<?php
namespace Spr\Base\Models;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use Spr\Base\Response\Response;
use Spr\Base\Models\Helper;
use DB;
use Config;
class LogSendEmailMatch extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'log_send_email_match';
	public $timestamps = false;


	public function __construct(){

	}

	public function getDataByCode ($code) {

		$results = Response::response();

		try {
			$query = DB::table($this->table)->select()
						->where('code','=',$code)->get();

			$results['response'] = $query;
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['code'] = 501;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

	public function insertNewLog($data) {

		$Helper = Helper::insert($this->table, $data);
		return $Helper;
	}

	public function updateLogByCode($code, $data) {

		$where = array(
			array(
				'fields' 	=> 'code',
				'operator' 	=> '=',
				'value' 	=> $code
			)
		);
		return Helper::update_db( $this->table, $data, $where);
	}
}
