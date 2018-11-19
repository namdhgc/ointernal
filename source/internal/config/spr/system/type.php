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
		'status'=> [
			[
				'title'	=> "groupImage.search.media-status.all",
				'value'	=> ""
			],
			[
				'title'	=> "groupImage.search.media-status.used",
				'value'	=> 1
			],
			[
				'title'	=> "groupImage.search.media-status.not-used",
				'value'	=> 0
			]
		],
		'image'	=> 0,
		'video' => 1
	],
	'item_on_paginate'=> [
		[
			'text'	=> "10",
			'value'	=> 10
		],
		[
			'text'	=> "50",
			'value'	=> 50
		],
		[
			'text'	=> "100",
			'value'	=> 100
		],
		[
			'text'	=> "500",
			'value'	=> 500
		],
		[
			'text'	=> 'setting.paginate.all',
			'value'	=> 0
		]
	]
];