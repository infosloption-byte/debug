<?php

namespace System\Hierarchy;

use Illuminate\Support\ServiceProvider;

class HierarchyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'Hierarchy');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *  
     * @return void
     */
    public function register()
    {
        $this->app->bind('Hierarchy', function($app){
            return new Hierarchy;
        });
    }
}
