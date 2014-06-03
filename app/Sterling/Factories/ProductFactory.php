<?php namespace Sterling\Factories;

class ProductFactory {
	
	public function bind($className)
	{
    	// bind the specified company product class to 'Product' in the IoC
		\App::bind('Product', function() use($className) {
			$class = 'Sterling\\Repositories\\Product\\ClientProducts\\' . $className ;
			return new $class();	 	
		});
	}

	public function make($className=NULL)
	{
		// determine class name from user company if not passed
		$className = $className ? $className : \Auth::user()->company->product_class;

		// check binding
		if(is_a(\App::make('Product'), 'Sterling\Facades\Product'))
			// bind
			$this->bind($className);
		
		// instantiate
		$product = \App::make('Product');
		
		// return
	 	return $product;
	}

}