<?php namespace Sterling\Repositories\PageGraphic;

use Illuminate\Support\ServiceProvider;

class PageGraphicServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'PageGraphic' instance container to our PageGraphic object
        $this->app['pagegraphic'] = $this->app->share(function($app)
        {
            return new PageGraphic;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('PageGraphic', 'Sterling\Facades\PageGraphic');
        });
    }
}