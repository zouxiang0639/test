<?php

namespace App\Library\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        'Encore\Admin\Console\MakeCommand',
        'Encore\Admin\Console\MenuCommand',
        'Encore\Admin\Console\InstallCommand',
        'Encore\Admin\Console\UninstallCommand',
        'Encore\Admin\Console\ImportCommand',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth'       => \App\Library\Admin\Middleware\Authenticate::class,
        'admin.Validator' => \App\Library\Admin\Middleware\RequestsValidator::class,
       // 'admin.pjax'       => \App\Http\Middleware\Admin\Pjax::class,
        //'admin.log'        => \App\Http\Middleware\Admin\LogOperation::class,
        //'admin.permission' => \App\Http\Middleware\Admin\Permission::class,
        //'admin.bootstrap'  => \App\Http\Middleware\Admin\Bootstrap::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
            'admin.Validator',
            //'admin.log',
            //'admin.bootstrap',
            //'admin.permission',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadAdminAuthConfig();
        $this->registerRouteMiddleware();
        $this->loadViewsFrom(app_path('Admin/views'), 'admin');
        $this->loadRoutesFrom(app_path('Admin/routes/routes.php'));
//        if (file_exists($routes = admin_path('routes.php'))) {
//
//        }
//
//        if ($this->app->runningInConsole()) {
//            $this->publishes([__DIR__.'/../config' => config_path()], 'laravel-admin-config');
//            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'laravel-admin-lang');
////            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/admin')],           'laravel-admin-views');
//            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'laravel-admin-migrations');
//            $this->publishes([__DIR__.'/../resources/assets' => public_path('vendor/laravel-admin')], 'laravel-admin-assets');
//        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("admin", function($app){
            return new Admin();
        });

    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
