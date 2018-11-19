<?php 

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Config;

/**
* 
*/
class Base
{
	
	function __construct()
	{
		# code...
	}

	// public function insert($table,$object){
        
 //        $Response = new Response();
 //        $results = $Response->response(200,'','',true);

 //        $data =  DB::table($table)->insert($object);

	// 	$result['response'] = $data;

 //        return $result;
 //    }

    public static function insert ( $table, $data, $where = array()) {
        // $Response = new Response();
        // $results = $Response->response(200,'','',true);

        try {
            $query = DB::table($table);

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

            $query->insert($data);

            $results = Response::response(200,'','',true);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg'] = $e->getMessage();
        }
        return $results;
    }


    public static function getAll($table, $column = array()){

        try {

            if ($column == null) { 

                $column = '*';
            }

            $data =  DB::table($table)
                        ->select($column)
                        // ->paginate(Config::get('pagination.perOnPage'))
                        ->get();

            $results = Response::response(200, '', $data);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['code'] = 401;
            $results['meta']['msg'] = $e->getMessage();
        }

        return $results;
    }


    public static function select($table, $where = array(), $limit = null, $offset = null, $selectType = null, $fields = null, $order = array()) {

        $query = DB::table($table)->select();

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

        if ($order != null) {

            foreach ($order as $key => $value) {
                
                $query = $query->orderBy($value['fields'], $value['operator']);
            }

        }

        // $data = $query->get();
        $data = $query->paginate(Config::get('mycnf.paginate'));

        $results = Response::response(200, '', $data);

        return $results;
    }


    // public static function findById($table, $id, $column = array()){
        
    //     if ($column == null) { 
    //         $column = '*';
    //     }

    //     $data =  DB::table($table)
    //     			->select($column)
    //     			->where('id','=',$id)
    //     			->get();

    //     $result = Response::response(200, '', $data);

    //     return $result;
    // }

    // public  function deleteByIds($table,$ids){
    // 	$data =  DB::table($table)
    // 				->whereIn('id',$ids)
    // 				->delete();

    // 	$result = Response::response(200, '', $data);

    // 	return $result;
    // }

    public  function update($table,$id,$object){
        $data = DB::table($table)
        			->where('id',$id)
        			->update($object);

        $result = Response::response(200, '', $data);

        return $result;
    }

    public static function update_db ($table, $data, $where) {
        // $Response = new Response();
        // $results = $Response->response(200,'','',true);

        try {

            $query = DB::table($table);

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

            // DB::enableQueryLog();
            $data = $query->update($data);

            $results = Response::response(200,'','',true);

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg'] = $e->getMessage();
        }
        return $results;
    }

    // public function findByCondition($table,$condition){
    //     $data = DB::table($table);

    //     if(isset($condition['username']) && !empty($condition['username'])){

    //         $data = $this->modCondition($data,$condition['username'],'username','like');
    //     }        

    //     if(isset($condition['email']) && !empty($condition['email'])){

    //         $data = $this->modCondition($data,$condition['email'],'email','like');
    //     }

    //     /*foreach ($condition as $key => $value) {
    //         if(!empty($value)){
    //            $data = $data->where($key,'LIKE','%'.$value.'%'); 
    //         }
    //     }*/

    //     // $data = $data->paginate(Config::get('pagination.perOnPage'));

    //     $result = Response::response(200, '', $data);

    //     return $result;
    // }
}