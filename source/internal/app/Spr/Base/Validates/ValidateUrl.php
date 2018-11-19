<?php

namespace Spr\Base\Validates;

use Config;
use Spr\Base\Response\Response;

class ValidateUrl
{
    
	public  function checkUrl($url){

		$result = Response::response();

		if(filter_var($url,FILTER_VALIDATE_URL)){
				
				$flag 	= false;
				//$domain = Config::get('spr.system.link_config.my_domain')[1];
				
				foreach(Config::get('spr.system.link_config.amazon') as $key => $value){
					
					if(strpos($url,$value) !== false){

						$flag 	= true;

						break;
					}
				}
				
				if($flag){

					if($this->checkDetailExist($url) == false){

						if($this->getKeyword("field-keywords",$url) !=""){
							$result['meta']['success']  = true;
							$result['response'] = '/s?'.$this->getKeyword('field-keywords',$url);

						}else if($this->getKeyword("node",$url) !=""){
							$result['meta']['success']  = true;
							$result['response']  = '/p?'.$this->getKeyword('node',$url);

						}else{

							$result['meta']['success']  = false;
							$result['meta']['code']	= 400;
							$result['meta']['msg']		= "You need enter the link category or link search.";
						}

					}else{
							$result['meta']['success']  = false;
							$result['meta']['code']	= 400;
							$result['meta']['msg']		= "The link detail is not acceptable";
					}
						
				}else{
					
					foreach(Config::get('spr.system.link_config.my_domain') as $k => $val){	

						if(strpos($url,$val) !== false){
							$flag = true;

							break;
						}
					}
					if($flag){
						if($this->checkDetailExist($url) == false){

							$url_base = explode("?",$url);

							// if(count($url_base) > 1){
								$result['meta']['success']  = true;
								$result['response'] = str_replace(url('/'),'',$url);

							// }else{

							// 	$result['meta']['success']  = false;
							// 	$result['meta']['code']	= 400;
							// 	$result['meta']['msg']		= "You need enter the link category or link search.";
							// }

						}else{
								$result['meta']['success']  = false;
								$result['meta']['code']	= 400;
								$result['meta']['msg']		= "The link detail is not acceptable";
						}
						
					}else{

							$result['meta']['success']  = false;
							$result['meta']['code']	= 400;
							$result['meta']['msg']		= "This link is not of amazon or my domain. ";
					}
						
				}
		}else{
				$result['meta']['success']  = false;
				$result['meta']['code']	= 400;
				$result['meta']['msg']		= "This link invalid.";
		}
		return $result;
	}

	public function checkKeyExist($key,$url){

	}
	public function getKeyword($key,$url){
		// xử lý url lấy tham số
		$url_base 	= 	explode('?',$url);
		$param 		=	""; 

		if(count($url_base) > 1){

			$param_key = explode('&',$url_base[1]);

			foreach ($param_key as $k => $value) {
				$sub_param  = [];
				$sub_param 	= explode('=', $value);

				if(count($sub_param) > 0){

					if(strcmp($sub_param[0], $key) == 0){
						if(strcmp("node", $key) == 0){
							$param = "n=".$sub_param[1];
						}else{
							$param = $value;
						}
						
						break;

					}
				}

			}
			
		}
		
		return $param;
	}
	public function checkDetailExist($url){

		$url_base 		= 	explode('?',$url);
		$result 		=	false; 

		if(count($url_base) > 1){

			$arr_param = explode("/", $url_base[0]);
			foreach ($arr_param as $key => $value) {
			
				if(strcmp($value, 'dp')==0){

					$result = true;
					break;
				}
			}
		}	
		return $result;		
	}
}