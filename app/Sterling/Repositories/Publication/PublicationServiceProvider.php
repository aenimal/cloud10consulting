<?php namespace Sterling\Repositories\Publication;

use Illuminate\Support\ServiceProvider;

class PublicationServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['publication'] = $this->app->share(function($app)
        {
            return new Publication;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Publication', 'Sterling\Facades\Publication');
        });
    }
}