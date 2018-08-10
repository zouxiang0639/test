<?php
namespace App\Library\Validators;

use Illuminate\Support\ServiceProvider;
use Validator;

/**
 * 验证器服务容器类
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return preg_match('/^1[0-9]{10}$/', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
