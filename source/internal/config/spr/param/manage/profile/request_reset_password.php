<?php
use Spr\Base\Config\Helper;


$dataParam = array(
 	array(
	 	'key' => 'email',
	 	'rules' => 'required',
	 	'message' => array(
	 		'required' 	=> 'message.web.error.0001',
	 		// 'email' 	=> 'message.web.error.0002'
	 	),
	 	'default' => '',
		'htmlentities' => false
 	),
);

$dataConfig = Helper::setDataConfig($dataParam);

return $dataConfig;