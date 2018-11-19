<?php

namespace App\Http\Models;

use App\Http\Response\Response;
use DB;

/**
* 
*/
class Department extends Base
{

	public static function GetDepartment() {

        try {

            $query   = DB::table('department')->select('id', 'name', 'phone_number', 'address')
                                              ->orderBy('name');

            $data    = $query->get();

            $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['code']    = 401;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }
}