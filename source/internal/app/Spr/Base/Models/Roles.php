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

class Roles extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';
	public $timestamps = false;


	public function __construct(){


		// $this->now = \Carbon\Carbon::now()->toDateTimeString();
	}

	public  function getAllData() {

		$where = [];
		

		$results = Helper::select($this->table, $where );
		
		return $results;
	}

	public function getDataManage ($limit, $sort, $sort_type) {


		$where = [
			[
				'fields' 	=> 'id',
				'operator' 	=> '<>',
				'value'		=> 1
			]
		];
		$order = [
			[
				'fields' => $sort,
				'operator'	=> $sort_type
			]
		];

		$results = Helper::select($this->table, $where , $limit, null, Config::get('spr.system.type.query.paginate'), null, $order );
		return $results;
	}

}
