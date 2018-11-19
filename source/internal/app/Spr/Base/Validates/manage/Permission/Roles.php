<?php
namespace Spr\Base\Validates\Manage\Permission;

use Config;
use Spr\Base\Response\Response;
use Lang;
use Spr\Base\Models\Roles as ModelRoles;
use Hash;
use Spr\Base\Validates\Helper;
use Auth;
use Cache;

class Roles {

    public function __construct () {

    }

	// public function validateNewAnnouncement ($dataOutputGetParam) {

	// 	$validator = Helper::validate($dataOutputGetParam);

	// 	if($validator['meta']['success']){
	// 		if(Cache::get('permissionRoles_'.Auth::user()->username)[Cache::get('module')['create-announcement']]['write'] != 1){
	// 			$validator['meta']['success'] = false;
	// 			$validator['meta']['msg'] = array(Lang::get('message.error.00041'));
	// 		}
	// 	}
	// 	return $validator;
	// }

	// public function validateEditAnnouncement ($dataOutputGetParam) {

	// 	$validator = Helper::validate($dataOutputGetParam);
	// 	if($validator['meta']['success']){
	// 		if(Cache::get('permissionRoles_'.Auth::user()->username)[Cache::get('module')['create-announcement']]['write'] != 1){
	// 			$validator['meta']['success'] = false;
	// 			$validator['meta']['msg'] = array(Lang::get('message.error.00041'));
	// 		}
	// 	}
	// 	return $validator;
	// }

	// public function validateVỉewRoles ($data_output_get_param) {

	// 	$validator = Helper::validate($data_output_get_param);
	// 	return $validator;
	// }
}