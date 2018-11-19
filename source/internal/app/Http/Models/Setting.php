<?php

namespace App\Http\Models;

use DB;
use Spr\Base\Models\Helper;
use Illuminate\Database\Eloquent\Model;
use Spr\Base\Response\Response;
use Config;

class Setting extends Model
{

	protected $table = "setting";

    public  function insertData($data) {
        $results = Helper::insertGetId($this->table, $data);
        return $results;
    }

    public function updateData($data,$where = array()){
        $results =  Helper::update_db($this->table,$data,$where);
        return $results;

    }

    public function checkIdExist($id) {

        $results = Response::response();

        try{

            $query = DB::table($this->table)->select(DB::raw('count(id) as total'))->where('id','=',$id)->whereNull('deleted_at')->first();

            $results['response'] = $query;
             

        }catch(Exception $ex){

            $results['meta']['success'] = false;
            $results['meta']['code'] = 500;
            $results['meta']['msg'] = $e->getMessage();
        }
        return $results;

    }

	public function getData($where = array()){

        $results    =   Response::response();

        try{

            $query    =   DB::table('setting as s')
                            ->select(
                                        's.id',
                                        's.key_setting',
                                        's.title',
                                        's.description',
                                        's.icon_class',
                                        's.icon',
                                        'm.path'
                                    )
                            ->leftjoin('media as m','m.id','=','s.icon');

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


            $results['response'] = $query->get();

        }catch(Exception $ex){

            $results['meta']['success'] = false;
            $results['meta']['code'] = 500;
            $results['meta']['msg'] = $e->getMessage();
        }

        return $results;
       
    }

    public function getCompanyInfo($key){

        $results    =   Response::response();

        try{

            $query    =   DB::table('setting as s')
                            ->select(
                                        's.title',
                                        's.description'
                                    )
                            ->where('s.key','=',$key)->get();

            $results['response'] = $query;

        }catch(Exception $ex){

            $results['meta']['success'] = false;
            $results['meta']['code'] = 500;
            $results['meta']['msg'] = $e->getMessage();
        }

        return $results;
    }

    public function getLogo(){

        $results    =   Response::response();

        try{

            $query    =   DB::table('setting as s')
                            ->select(
                                        's.icon',
                                        'm.path'
                                    )
                            ->join('media as m','m.id','=','s.icon')
                            ->where('s.key','=',Config::get('spr.type.setting.company-info.logo.key'))->get();

            $results['response'] = $query;

        }catch(Exception $ex){

            $results['meta']['success'] = false;
            $results['meta']['code'] = 500;
            $results['meta']['msg'] = $e->getMessage();
        }

        return $results;        
    }

    public function checkKeyExist($key) {

        $results = Response::response();

        try{

            $query = DB::table($this->table)->select('id','icon')->where('key','=',$key)->whereNull('deleted_at')->first();

            $results['response'] = $query;
             

        }catch(Exception $ex){

            $results['meta']['success'] = false;
            $results['meta']['code'] = 500;
            $results['meta']['msg'] = $e->getMessage();
        }
        return $results;

    }
}