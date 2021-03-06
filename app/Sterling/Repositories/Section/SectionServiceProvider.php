<?php namespace Sterling\Repositories\Section;

use Illuminate\Support\ServiceProvider;

class SectionServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['section'] = $this->app->share(function($app)
        {
            return new Section;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Section', 'Sterling\Facades\Section');
        });
    }
}