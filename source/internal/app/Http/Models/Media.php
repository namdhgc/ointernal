<?php

namespace App\Http\Models;

use DB;
use Spr\Base\Models\Helper;
use Illuminate\Database\Eloquent\Model;
use Config;

class Media extends Model
{

	protected $table = "media";

    public  function insertData($data) {
        $results = Helper::insertGetId($this->table, $data);
        return $results;
    }

    public function updateData($data,$where = array()){
        $results =  Helper::update_db($this->table,$data,$where);
        return $results;
    }
    public function getDataManage ($key_search, $limit, $sort, $sort_type) {


		$where = [
			[
				'fields' => 'name',
				'operator' => 'like',
				'value' => $key_search,
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