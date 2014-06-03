<?php

use Sterling\Factories\MenuFactory;
use Sterling\Decorators\MenuDecorator;

class MainController extends BaseController {

	public function __construct(
		MenuFactory $MenuFactory,
		MenuDecorator $MenuDecorator
		/* ...more dependency injections here */
	){
		//parent::__construct();

		// assign injected classes
		$this->MenuFactory = $MenuFactory;
		$this->MenuDecorator = $MenuDecorator;

		// create main menu
		$this->menu = $this->MenuFactory->newMenu('main');

	}

	public function home()
	{
		$page = ['title'=>'Welcome'];
		return View::make('home')->withPage($page);
	}

	public function showPage($page_ref)
	{
		$page = Config::get('pages.'.$page_ref);
		return View::make($page_ref)->withPage($page);
	}

}
