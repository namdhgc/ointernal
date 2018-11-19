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
class Module extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'module';
	public $timestamps = false;


	public function __construct(){


		// $this->now = \Carbon\Carbon::now()->toDateTimeString();
	}

	public function getAllData () {
		$Helper = new Helper();
		$results = $Helper->select($this->table, array());
		return $results;
	}

}
