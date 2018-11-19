<?php
return [
	'query' => [
		'count' => 1,
		'max' => 2,
		'min' => 3,
		'get' => 4,
		'first' => 5,
		'paginate' => 6
	],
	'media' => [
		'image'	=> 0,
		'video' => 1
	],
	'price' => [
			" "  =>	[
				'title' => "---    Please choose     ---",
				'value'	=> ''
			],
			'default'  => [
				'title'	=> 'Default',
				'value'	=> 0
			],
			'normal'  => [
				'title'	=> 'Normal',
				'value'	=> 1
			]
	],
	'lang' =>[
		'en' => 'English',
		'ja' => 'Japanese',
		'vi' => 'Vietnamese',
	],
	'type-price'	=>	[

		//'参考価格:' 	=>	'Reference Price',
		'価格：'		=>	'Price',
		'セール価格:'	=>	'Sale',
	],
	'payment'	=> [
		'online' 	=> [

			'value'			=>	0,
			'title'			=>	'Thanh toán trực tuyến với <br> 27 ngân hàng trong nước',
			'description'	=>	'Để thanh toán trực tuyến, tài khoản ngân hàng của bạn phải đăng ký sử dụng internet banking ',
			'icon'			=>	'/fado/images/icon-bank-card.png',

		],
		'on-company' 	=> [

			'value'			=>	1,
			'title'			=>	'Thanh toán tại văn phòng',
			'description'	=>	'Nhân viên của công ty sẽ hỗ trợ khách hàng thanh toán',
			'icon'			=>	'/fado/images/icon-payment-5.png',
		],
		'on-customer-home' 	=> [

			'value'			=>	2,
			'title'			=>	'Thanh toán tại nhà',
			'description'	=>	'Nhân viên giao hàng sẽ hỗ trợ khách hàng làm thủ tục thanh toán đơn hàng',
			'icon'			=>	'/fado/images/icon-payment-7.png',

		],
	],

	'weight'	=>	[
			'g'		=>	[

				 '1'	=>	'0.001',
			],

			'kg' 	=>	[

				'1'	=>	'1',
			],

			'pound'		=>	[

				'1'	=>	'0.45359237'
			],

	],
	'verify'	=>	[

		'1'	=>	'message.verify.1',
		'0'	=>	'message.verify.0',

	],
];