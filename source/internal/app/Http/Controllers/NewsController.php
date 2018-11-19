<?php

namespace App\Http\Controllers;

use App\Http\Models\News;
use App\Http\Models\Base;
use Config;
use Input;
use Auth;


/**
* 
*/
class NewsController extends Controller
{

	protected $table = 'post';
	
	function __construct()
	{
		# code...
	}

	public function uploadNews() {

    	$where = [];

    	$title 			= Input::get('title');
    	$content 		= Input::get('content');
    	$cateId 		= '1';
    	$createdById 	= Auth::user()->id;

    	if ($title != '' || $content != '') {
    		
    		$data = [
    			'title'			=> $title,
    			'content'		=> $content,
    			'cateId'		=> $cateId,
    			'cateId'		=> $cateId,
    			'createById'	=> $createdById,
    			'created_date'	=> strtotime(\Carbon\Carbon::now()->toDateTimeString()),
    		];

            $results = Base::insert($this->table, $data, $where);

            return $results;
    	} else {

    		return false;
    	}
    }

    public function getData() {

    	$where = [];

    	$order = [
    		[
    			'fields'	=> 'created_date',
    			'operator'	=> 'desc'
    		]
    	];

    	// $results = Base::select($this->table, $where = array(), $limit = null, $offset = null, $selectType = null, $fields = null, $order);
    	$results = News::selectData($where, $order);

    	// echo "<pre>";
    	// print_r($results);
    	// exit;

    	return $results;
    }

    public function editNews() {

        $id         = Input::get('id');
        $title      = Input::get('title');
        $content    = Input::get('content');

        $where = [
            [
                'fields'    => 'id',
                'operator'  => '=',
                'value'     => $id
            ]
        ];

        $data = [
            'title'         => $title,
            'content'       => $content,
            'updated_date'  => strtotime(\Carbon\Carbon::now()->toDateTimeString())
        ];

        $results = Base::update_db($this->table, $data, $where);

        return $results;
    }
}