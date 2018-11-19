<?php 

namespace App\Http\Get;

use Input;

class Helper
{
	public static function GetData() {
		
		// $val = new Validate();
		// if ($val->validate($data))
		// 	return $data;
		// else
		// 	return false;

		$data = Input::get();
		
		// if validate
		$result = Response::response(200, '', $data);

		//if not validate
		//$result = Response::response(404, 'Not found', array(), false);


		return $result;
	}
}