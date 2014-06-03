<?php namespace Sterling\Repositories\User\Profile;

use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['profile'] = $this->app->share(function($app)
        {
            return new Profile;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Profile', 'Sterling\Facades\Profile');
        });
    }
}