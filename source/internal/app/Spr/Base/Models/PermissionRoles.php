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

class PermissionRoles extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_roles';
	public $timestamps = false;


	public function __construct(){


		// $this->now = \Carbon\Carbon::now()->toDateTimeString();
	}

	public function getAllDataRoles () {

		$Helper = new Helper();
		$where = array();
		$results = $Helper->select($this->table, $where);
		return $results;
	}

	public function getDataByRolesId ($roles_id) {
		$Helper = new Helper();
		$where = array(
			array(
				'fields' => 'roles_id',
				'operator' => '=',
				'value' => $roles_id
			)
		);
		$results = $Helper->select($this->table, $where);
		return $results;
	}

}
