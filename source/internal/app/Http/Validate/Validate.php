<?php 

namespace App\Http\Validate;

class Validate
{
	public function validate($data) {
		if (validate($data))
			return $data;
		else
			return false;
	}
}