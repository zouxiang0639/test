<?php

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "HomeController@index", 'as' => 'm.logout']);


    Route::group(['prefix'=>'users'], function(){
        Route::get('', ['uses' => "UserController@index", 'as' => 'm.user.index']);
//        $router->resource('auth/roles', 'RoleController');
//        $router->resource('auth/permissions', 'PermissionController');
//        $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);
//        $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']]);
    });
    Route::get('auth/users', ['uses' => "AuthController@index", 'as' => 'm.auth.users']);
});


