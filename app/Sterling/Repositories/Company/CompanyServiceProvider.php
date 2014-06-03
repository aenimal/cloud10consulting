<?php namespace Sterling\Repositories\Company;

use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
	public function register()
    {
		// Register 'company' instance container to our Company object
        $this->app['company'] = $this->app->share(function($app)
        {
            return new Company;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Company', 'Sterling\Facades\Company');
        });
    }
}