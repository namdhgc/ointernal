<?php
namespace Spr\Base\Validates;

use Config;
use Spr\Base\Response\Response;
use Lang;
use Hash;
use Validator;
use Auth;

class Helper {

    public function __construct () {

    }

    public static function validate($dataOutputGetParam) {

    	$msg = array();
		$Response   = new Response();
        $results    = $Response->response(200,'',array(),true);

		foreach ($dataOutputGetParam as $key => $value) {

			$htmlentities = $value['validate']['htmlentities'];

			if(!empty($value['validate']) && isset($value['validate']['param'])) {

				$param = $value['validate']['param'];
				$rules = $value['validate']['rules'];
				$messages = $value['validate']['messages'];

				$validator = Validator::make($param, $rules, $messages);
		    	if (!$validator->passes()) {

					foreach ($validator->errors()->all() as $msgError) {
					    $msg[ $value['key'] ] = $msgError;
					}
				}
				else {
					$valueParam = $value['value'];

					if(!is_array($valueParam) && !is_object($valueParam) ) {
						$valueParam = trim($valueParam);
					};
					// if($htmlentities) $valueParam = htmlentities($valueParam);

					$results['response'][$value['key']] = $valueParam;

				}
			}else {

				$valueParam = $value['value'];
				
				if(!is_array($valueParam) && (!isset($value['save']) || (isset($value['save']) && !$value['save'] ))) {
				 
				  	$valueParam = trim($valueParam);
				}
				// if($htmlentities) $valueParam = htmlentities($valueParam);

				$results['response'][$value['key']] = $valueParam;
			}
		}

		if(empty($msg)) {

			$results['meta']['msg'] = $msg;
			$results['meta']['success'] = true;
            $results['response']['created_at'] = strtotime(\Carbon\Carbon::now()->toDateTimeString());
            $results['response']['updated_at'] = strtotime(\Carbon\Carbon::now()->toDateTimeString());


		}else {

			$results['meta']['msg'] = $msg;
			$results['meta']['success'] = false;
			$results['meta']['code'] = 501;
			$results['response'] = array();
		}

		return $results;
    }

	public static function validateAuth() {

		if(Auth::check()) {
			return '';
		}else {
			return Lang::get('message.error.00016');
		}
	}

	public static function baseValidate ($data_output_get_param) {

		$validator = Helper::validate($data_output_get_param);
		return $validator;
	}

	public static function otherValidate ($param, $rules, $messages) {

		$results = Response::response();
		$validator = Validator::make($param, $rules, $messages);
		$msg = [];
    	if (!$validator->passes()) {

			foreach ($validator->errors()->all() as $msgError) {

				foreach ($param as $param_key => $param_value) {
			    	
			    	$msg[ $param_key ] = $msgError;
			    	break;
				}
			}
		}
		if(!empty($msg)) {

			$results['meta']['success'] = false;
			$results['meta']['msg'] 	= $msg;
			$results['meta']['code'] 	= 501;

		}
		return $results;
	}
}