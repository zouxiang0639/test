<?php

Route::group([
    'prefix' => 'canteen',
    'namespace' => 'App\\Canteen\\Controllers',
    'middleware' => ['web', 'canteen'],
], function(){
    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);


    //登录等功能
    Route::group(['prefix'=>'auth'], function(){
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'f.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@loginPut", 'as' => 'f.auth.login.put']);
        Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'f.auth.logout']);
    });
});