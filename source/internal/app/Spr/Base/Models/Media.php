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
class Media extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'media';
	public $timestamps = false;
	

	public function __construct(){

		
		// $this->now = \Carbon\Carbon::now()->toDateTimeString();
	}

	public function createNewImg( $data) {
		$Helper = new Helper();
		$results = $Helper->insertGetId($this->table, $data);
		return $results;
	}	

	public function getDataById( $id) {
		$where = array(
            array(
                'fields'    => 'id',
                'operator'  => '=',
                'value'     => $id
            )
        );
        return Helper::select( $this->table, $where);
	}	

	public function getDataInId( $id) {
		$where = array(
            array(
                'fields'    => 'id',
                'operator'  => 'in',
                'value'     => $id
            )
        );
        return Helper::select( $this->table, $where);
	}
}
