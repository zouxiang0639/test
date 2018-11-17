<?php

namespace App\Library\Forum;

use App\Forum\Composers\Composer;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
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
        'forum.auth'       => \App\Library\Forum\Middleware\Authenticate::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'forum' => [
            'forum.auth',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Composer::boot(); //注册视图Composer
        $this->loadAdminAuthConfig();
        $this->registerRouteMiddleware();
        $this->loadViewsFrom(app_path('Forum/views'), 'forum');
        $this->loadRoutesFrom(app_path('Forum/routes/routes.php'));

        //h5
        $this->loadViewsFrom(app_path('H5/views'), 'h5');
        $this->loadRoutesFrom(app_path('H5/routes/routes.php'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("forum", function($app){
            return new Forum();
        });

    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('forum.auth', []), 'auth.'));
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
