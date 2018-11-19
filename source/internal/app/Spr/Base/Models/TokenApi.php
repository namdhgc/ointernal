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
class TokenApi extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'token_api';
	public $timestamps = false;


	public function __construct(){

	}

	public function CheckAuthenticate ($public_key, $private_key) {

		$results = Response::response();

		try {
			$query = DB::table($this->table)->select()
						->where('public_key','=',$public_key)
						->where('private_key','=', $private_key)
						->where('status','=',Config::get('spr.system.status.api.used'));

			$results['response'] = $query;
		} catch (PDOException $e) {

			$results['meta']['success'] = false;
			$results['meta']['code'] = 501;
			$results['meta']['msg'] = $e->getMessage();
		}
		return $results;
	}

}
