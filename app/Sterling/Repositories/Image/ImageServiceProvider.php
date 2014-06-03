<?php namespace Sterling\Repositories\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'image' instance container to our Image object
        $this->app['imageapp'] = $this->app->share(function($app)
        {
            return new Image;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Image', 'Sterling\Facades\Image');
        });
    }
}