<?php

namespace App\Http\Models;

use App\Http\Response\Response;
use Config;
use DB;

/**
* 
*/
class News extends Base
{

	public static function selectData($where = array(), $order = array()) {

		try {
			$query =  DB::table('post as p')
	                    ->select('p.id',
	                    			'p.title',
	                    			'p.content',
	                    			'p.cateId',
	                    			'p.createById',
	                    			'p.created_date',
	                    			'p.updated_date',
	                    			'e.firstname',
	                    			'e.lastname',
	                    			'e.displayName'
	                    		)
	        			->join('employee as e', 'p.createById', '=', 'e.id');

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

	        foreach ($order as $key => $value) {
                
                $query = $query->orderBy($value['fields'], $value['operator']);
            }

	        $data = $query->paginate(Config::get('mycnf.paginate'));
	        $results = Response::response(200, '', $data);
			
		} catch (Exception $e) {
			
			$results['meta']['success'] = false;
            $results['meta']['code'] = 401;
            $results['meta']['msg'] = $e->getMessage();
		}

	  	return $results;
	}
}