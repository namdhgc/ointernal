<?php
use Spr\Base\Config\Helper;


$dataParam = array(

	array(
	 	'key' => 'image',
	 	'rules' => 'nullable | mimes:jpeg,png,jpg,gif,svg',
	 	'message' => array(),
	 	'default' => '',
		'htmlentities' => false
 	),
	array(
	 	'key' => 'icon',
	 	'rules' => '',
	 	'message' => array(),
	 	'default' => '',
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'company_name',
	 	'rules' => 'required',
	 	'message' => array(
	 		'required' 	=> 'message.web.error.0001',
	 	),
	 	'default' => '',
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'email',
	 	'rules' => 'required|email',
	 	'message' => array(
	 		'required' 	=> 'message.web.error.0001',
	 		'email' 	=> 'message.web.error.0002'
	 	),
	 	'default' => '',
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'phone_number',
	 	'rules' => 'required',
	 	'message' => array(
	 		'required' 	=> 'message.web.error.0001',
	 	),
	 	'default' => '',
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'address',
	 	'rules' => 'required',
	 	'message' => array(
	 		'required' 	=> 'message.web.error.0001',
	 	),
	 	'default' => '',
		'htmlentities' => false
 	),
 	array(
	 	'key' => 'description',
	 	'rules' => '',
	 	'message' => array(),
	 	'default' => '',
		'htmlentities' => false
 	)

);

$dataConfig = Helper::setDataConfig($dataParam);

return $dataConfig;