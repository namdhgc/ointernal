<?php

namespace App\Http\Controllers;

use App\Http\Models\UploadFile;
use App\Http\Models\Base;
use Config;
use Input;
use Auth;

class UploadFileController extends Controller
{
	protected $table = 'document';

    public function uploadFile() {

    	$where = [];

        $upload_file_avoid  = Config::get('upload_file_avoid');
        $flag               = true;

		$file_upload   	= $_FILES["upload_file"];
        $file_name      = $file_upload['name'];
		$extension 		= substr($file_name, strpos($file_name, '.') + 1);

        foreach ($upload_file_avoid as $key => $value) {
            
            if ($extension == $value) {
                
                $flag = false;
                break;
            }
        }

        if ($flag) {
        
            $temp_name      = $file_upload['tmp_name'];
            $file_type      = $file_upload['type'];
            $time_stamp     = strtotime(\Carbon\Carbon::now()->toDateTimeString());
            $path           = public_path('upload_file');
            $createById     = Auth::user()->id;


            $data = [
                'name'              => $file_name,
                'temp_name'         => $time_stamp,
                'extension'         => $extension,
                'path'              => $path,
                'type'              => null,
                'createById'        => $createById,
                'created_date'      => $time_stamp,
            ];

            $results = Base::insert($this->table, $data, $where);

            move_uploaded_file($temp_name, $path . '/' . $time_stamp . '.' . $extension);

            return $results;
        } else {

            return false;
        }
    }

    public function getData() {

        $where = [
            [
                'fields'    => 'deleted_date',
                'operator'  => 'null'
            ]
        ];

    	$order = [
    		[
    			'fields'	=> 'name',
    			'operator'	=> 'asc'
    		],
    		[
    			'fields'	=> 'extension',
    			'operator'	=> 'asc'
    		]
    	];

    	$results = Base::select($this->table, $where, $limit = null, $offset = null, $selectType = null, $fields = null, $order);

    	return $results;
    }

    public function deleteData() {

        $data   = [];
        $where  = [];

        $id = Input::get('id');

        $where = [
            [
                'fields'    => 'id',
                'operator'  => '=',
                'value'     =>  $id
            ]
        ];

        $data['deleted_date'] = strtotime(\Carbon\Carbon::now()->toDateTimeString());

        $results = Base::update_db($this->table, $data, $where);

        return $results;
    }
}