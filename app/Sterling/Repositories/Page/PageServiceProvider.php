<?php namespace Sterling\Repositories\Page;

use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['page'] = $this->app->share(function($app)
        {
            return new Page;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Page', 'Sterling\Facades\Page');
        });
    }
}