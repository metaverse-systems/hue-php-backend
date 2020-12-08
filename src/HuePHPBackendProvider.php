<?php

namespace MetaverseSystems\HuePHPBackend;

use Illuminate\Support\ServiceProvider;

class HuePHPBackendProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(!$this->app->routesAreCached())
        {
            require __DIR__.'/Routes.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }
}
