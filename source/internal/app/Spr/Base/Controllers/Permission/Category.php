<?php

namespace Spr\Base\Controllers\Permission;

use Spr\Base\Models\Category as ModelCategory;
use App\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Init;
use Shaphira\Base\Response\Response;
use Illuminate\Support\Facades\Input;
use Config;
use Auth;
use Cache;
use Session;
use Mail;
use Hash;
use Lang;

/**
* 
*/
class Category extends Controller
{
	
	function __construct()
	{
		# code...
	}

	public function getData($data_output_validate_param) {

        $where = [];

        $sort           = $data_output_validate_param['response']['sort'];
        $limit          = $data_output_validate_param['response']['limit'];
        $sort_type      = $data_output_validate_param['response']['sort_type'];

        $type_category  = $data_output_validate_param['response']['type_category'];
        $item_search    = $data_output_validate_param['response']['item_search'];

        $where = [
            [
                'fields'    => 'deleted_time',
                'operator'  => 'null',
                'value'     => ''
            ]
        ];

        if ($type_category != '') {
            
            $tmp = [
                'fields'    => $type_category,
                'operator'  => 'LIKE',
                'value'     => '%' . $item_search . '%'
            ];

            array_push($where, $tmp);
        }

        if($data_output_validate_param['meta']['success']) {

            $table  = '';
            $ModelCategory = new ModelCategory();

            $data = $ModelCategory->getDataManage($limit, $sort, $sort_type, $where);

            return array('data' => $data, 'sort' => $sort, 'limit' => $limit , 'sort_type' => $sort_type, 'type_category' => $type_category, 'item_search' => $item_search);
        }else {

            $data_output_validate_param['response'] = array();
            return array('data' => $data_output_validate_param, 'sort' => $sort, 'limit' => $limit , 'sort_type' => $sort_type);
        }
    }
}