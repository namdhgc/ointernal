<?php
namespace Spr\Base\Config;

use Spr\Base\Response\Response;
use App\Http\Models\User;
use Lang;
use Hash;
use Config;
use Validator;

class Helper {

    public function __construct () {

    }

    public function setDataConfig($config) {

    	$dataConfig = array('keys' => array());
    	$htmlentities = false;

		foreach ($config as $key => $value) {

    		(!isset($value['htmlentities'])) ?:  $htmlentities = $value['htmlentities'];
    		$save = (isset($value['save']))? $value['save'] : false;
			$validate = array('htmlentities' => $htmlentities);

			if($value['rules'] != ''){

				$validate = array(
					'param' => array(
						$value['key'].'' => ''
					),
					'rules' => array(
						$value['key'].'' => $value['rules']
					),
					'messages' => $value['message'],
					'htmlentities' => $htmlentities
				);
			}
			$default = null;
			if(isset($value['default'])){
	    		$default = $value['default'];
	    	}
			$newData = array(
				'key' => $value['key'],
				'validate' => $validate,
				'default' => $default,
				'save' => $save
			);

			array_push($dataConfig['keys'], $newData );
		}

		return $dataConfig;
    }
}