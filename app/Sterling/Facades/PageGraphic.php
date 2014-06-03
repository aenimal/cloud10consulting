<?php

namespace Sterling\Facades;

use Illuminate\Support\Facades\Facade;

class PageGraphic extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
    protected static function getFacadeAccessor() { 
    	return 'pagegraphic'; 
    }

}