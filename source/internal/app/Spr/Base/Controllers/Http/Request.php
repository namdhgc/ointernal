<?php
namespace Spr\Base\Controllers\Http;

use Spr\Base\Validates\ValidateInput;
use Input;
use Lang;
use Cache;
use Spr\Base\Controllers\Helper as HelperController;

class Request  {

	public function getDataRequest ($config, $input_value = "") {

		$dataOutputGetDataRequest = array();
		try{

			$lengthKey = COUNT( $config['keys'] );

			for($i = $lengthKey - 1; $i >= 0; $i--){

				if($input_value == "") {
					
					$value = $this->getValueOfParam($config['keys'][$i]);
				}else{
					$value = $input_value;
				}

				$config['keys'][$i]['validate'] = $this->getValidateOfParam($value, $config['keys'][$i]);
				$save = (isset($config['keys'][$i]['save']))? $config['keys'][$i]['save'] : false;
				if($config['keys'][$i]['key'] == 'file'){
					$file = Input::file( 'file' );

			        if ( !empty( $file ) )
			        {
			            foreach ( $file as $key => $image ) // add individual rules to each image
			            {
			                $config['keys'][$i]['validate']['rules'][ sprintf( 'file.%d', $key ) ] = 'required|mimes:jpeg,bmp,png';
			            }
			        }
					array_push($dataOutputGetDataRequest, array(
												'key'	=> $config['keys'][$i]['key'],
												'save'  => $save,
												'value' => $value,
												'validate' =>  $config['keys'][$i]['validate']
												));
				}else {
					array_push($dataOutputGetDataRequest, array(
													'key'	=> $config['keys'][$i]['key'],
													'save'  => $save,
													'value' => $value,
													'validate' =>  $config['keys'][$i]['validate']
													));
				}

			}
		} catch (Exception $e) {

			$Response = new Response();
			return $Response->response('500', Lang::get('message.error.00013'), '', false);
		}
		return $dataOutputGetDataRequest;
	}

	// public function getFilesRequest () {
	// 	$rules = [ 'files' => 'required|array|max:4000' ];

 //        $images = Input::file( 'files' );

 //        if ( !empty( $images ) )
 //        {
 //            foreach ( $images as $key => $image ) // add individual rules to each image
 //            {
 //                $rules[ sprintf( 'images.%d', $key ) ] = 'required|image';
 //            }
 //        }
 //        return $rules;
	// }

	public function getValueOfParam ($configParam) {

		$value = null;
		if( Input::file($configParam['key']) != null ){
			$value = Input::file($configParam['key']);
		}
		else{
			$value = Input::get($configParam['key']);
		}

		if(isset($configParam['validate']['htmlentities']) && $configParam['validate']['htmlentities']) $value = HelperController::html_entity_encode_XSS_attack($value);

		if($value == null || $value == '') {

			$value = $configParam['default'];
		}
		return $value;
	}

	public function getValidateOfParam ($valueOfParam, $configParam){

		$newArray = $configParam['validate'];
		if( !empty( $newArray ) && isset($newArray['messages'])) {

			$newArray['param'][$configParam['key']] = $valueOfParam;

			foreach ($newArray['messages'] as $key => $message) {

				$newArray['messages'][$key] = Lang::get($message);
			}
		}
		return $newArray;
	}

	public function getXml ($source) {
		$xmlData = NULL;

		try {
			$xmlRequest = @file_get_contents($source);
			if($xmlRequest === FALSE){
				$xmlData = false;
			}else {
				$xmlData = NULL;
				$p = xml_parser_create();
				xml_parse_into_struct($p,$xmlRequest , $xmlData);
			}
		} catch (Exception $e) {
			$xmlData = false;
		}


		return $xmlData;
	}

	public function getJsonFromUrl ($source) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $source);
		$result = curl_exec($ch);
		curl_close($ch);

		$obj = json_decode($result);
		return $obj;
	}

	public static function get_data_curl($url,$fields = array()){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if(strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile') !==false){
        	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        }else{

        	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Origin: https://www.amazon.co.jp', 'Referer:'.$url));

        if(count($fields) > 0){
            curl_setopt($ch, CURLOPT_POST, count($fields));
            $fields_string = "";
            foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }
            rtrim($fields_string, '&');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        }
        $html=curl_exec($ch);
        curl_close($ch);
        return $html;

    }

    public static function getHotDealsAmazon($str_param,$url,$market_id){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if(strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false){
        	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        }else{
        	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Origin: https://www.amazon.co.jp', 'Referer:https://www.amazon.co.jp/gp/goldbox/'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"requestMetadata":{"marketplaceID":"'.$market_id.'","clientID":"goldbox_mobile_pc","sessionID":"358-0374196-4484537"},"dealTargets":['.$str_param.'],"responseSize":"ALL","itemResponseSize":"DEFAULT_WITH_PREEMPTIVE_LEAKING","widgetContext":{"pageType":"GoldBox","subPageType":"main","deviceType":"pc","refRID":"96EYRDDVWBTDJGW3VFDT","widgetID":"f4ebe3b4-e619-4b56-999a-6f61c5135283","slotName":"slot-4"}}');
        $html=curl_exec($ch);
        curl_close($ch);
        return $html;
    }
}
?>