<?php namespace Sterling\Repositories\ProductImage;

use Illuminate\Support\ServiceProvider;

class ProductImageServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'productimage' instance container to our ProductImage object
        $this->app['productimage'] = $this->app->share(function($app)
        {
            return new ProductImage;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('ProductImage', 'Sterling\Facades\ProductImage');
        });
    }
}