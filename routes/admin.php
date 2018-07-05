<?php
use \Illuminate\Routing\Router;

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "HomeController@index", 'as' => 'm.logout']);
});


