<?php namespace Sterling\Repositories\Product;

use Sterling\Repositories\Product\ClientProducts;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'product' instance container to our Product object
        // $this->app['product'] = $this->app->share(function($app)
        // {
        //     return new ClientProducts\AcmeStandardProduct;
        // });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Product', 'Sterling\Facades\Product');
        });
    }
}