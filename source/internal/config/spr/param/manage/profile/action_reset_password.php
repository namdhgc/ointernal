<?php 

use Spr\Base\Config\Helper;


$dataParam = array(
	array(
	 	'key' => 'password',
	 	'rules' => 'required|max:200',
	 	'message' => array(
	 		'required'	=> 'message.web.error.0001',
	 		'max'		=> 'message.web.error.0003'
	 	),
	 	'default' => null,
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'password_retype',
	 	'rules' => 'required|max:200',
	 	'message' => array(
	 		'required'	=> 'message.web.error.0001',
	 		'max'		=> 'message.web.error.0003'
	 	),
	 	'default' => null,
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'email',
	 	'rules' => 'required|max:200',
	 	'message' => array(
	 		'required'	=> 'message.web.error.0001',
	 		'max'		=> 'message.web.error.0003'
	 	),
	 	'default' => null,
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'token',
	 	'rules' => 'required|max:200',
	 	'message' => array(
	 		'required'	=> 'message.web.error.0001',
	 		'max'		=> 'message.web.error.0003'
	 	),
	 	'default' => null,
		'htmlentities' => false
 	),
);

$dataConfig = Helper::setDataConfig($dataParam);

return $dataConfig;
