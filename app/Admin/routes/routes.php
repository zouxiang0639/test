<?php

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'm.logout']);


    Route::group(['prefix'=>'users'], function(){
        Route::get('', ['uses' => "UserController@index", 'as' => 'm.user.list']);
        Route::get('edit/{id}', ['uses' => "UserController@edit", 'as' => 'm.user.edit']);
        Route::post('update/{id}', ['uses' => "UserController@update", 'as' => 'm.user.update']);
//        $router->resource('auth/roles', 'RoleController');
//        $router->resource('auth/permissions', 'PermissionController');
//        $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);
//        $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']]);
    });

    Route::group(['prefix'=>'role'], function(){
        Route::get('', ['uses' => "RoleController@index", 'as' => 'm.role.list']);
        Route::get('edit/{id}', ['uses' => "RoleController@edit", 'as' => 'm.role.edit']);
        Route::post('update/{id}', ['uses' => "RoleController@update", 'as' => 'm.role.update']);
        Route::get('create', ['uses' => "RoleController@create", 'as' => 'm.role.create']);
        Route::post('store', ['uses' => "RoleController@store", 'as' => 'm.role.store']);
//        $router->resource('auth/roles', 'RoleController');
//        $router->resource('auth/permissions', 'PermissionController');
//        $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);
//        $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']]);
    });
    Route::get('auth/users', ['uses' => "AuthController@index", 'as' => 'm.auth.users']);
});


