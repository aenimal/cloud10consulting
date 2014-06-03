<?php

return array(

	'title' => 'Cloud10 Consulting - HR, Training &amp; Development, Personal &amp; Business Coaching',

	'pages'	=> [
		'home'	=> [
			'title'	=> 'Welcome',
		],
		'services'	=> [
			'title'	=> 'Services',
		],
		'about'	=> [
			'title'	=> 'About',
		],
		'testimonials'	=> [
			'title'	=> 'Client testimonials',
		],
		'contact'	=> [
			'title'	=> 'Contact',
		],
	],

	'menus' => [

		'main' => [
			'class'	=> 'nav nav-pills pull-right',
			'id'	=> '',
			'items'	=> [

				[ // 
					'href'		=> '/',
					'label'		=> 'Home',
					'icon'		=> 'home',
					'ref'		=> 'home',
					'items'		=> []
				],
				[ // 
					'href'		=> '/services',
					'label'		=> 'Services',
					'icon'		=> 'cog',
					'ref'		=> 'services',
					'items'		=> []
				],
				[ // 
					'href'		=> '/testimonials',
					'label'		=> 'Testimonials',
					'icon'		=> 'comment',
					'ref'		=> 'testimonials',
					'items'		=> []
				],
				// [ // 
				// 	'href'		=> '/about',
				// 	'label'		=> 'About',
				// 	'icon'		=> 'picture-o',
				// 	'ref'		=> 'about',
				// 	'items'		=> []
				// ],
				[ // 
					'href'		=> '/contact',
					'label'		=> 'Contact',
					'icon'		=> 'envelope',
					'ref'		=> 'contact',
					'items'		=> []
				],
			]

		] // main
	] // menus
);