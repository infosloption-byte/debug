<?php

namespace System\CrudGenerator;

use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/crudgenerator.php' => config_path('crudgenerator.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/views/' => base_path('resources/views/'),
        ]);

        if (\App::VERSION() <= '5.2') {
            $this->publishes([
                __DIR__ . '/../publish/css/app.css' => public_path('css/app.css'),
            ]);
        }

        $this->publishes([
            __DIR__ . '/stubs/' => base_path('resources/crud-generator/'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../views', 'CrudGenerator');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'System\CrudGenerator\Commands\CrudCommand',
            'System\CrudGenerator\Commands\CrudControllerCommand',
            'System\CrudGenerator\Commands\CrudControllerLogicCommand',
            'System\CrudGenerator\Commands\CrudModelCommand',
            'System\CrudGenerator\Commands\CrudMigrationCommand',
            'System\CrudGenerator\Commands\CrudViewCommand',
            'System\CrudGenerator\Commands\CrudLangCommand',
            'System\CrudGenerator\Commands\CrudRouteCommand'
        );
    }
}
