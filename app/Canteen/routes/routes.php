<?php

Route::group([
    'prefix' => 'canteen',
    'namespace' => 'App\\Canteen\\Controllers',
    'middleware' => ['web', 'canteen'],
], function(){
    Route::get('/', ['uses' => "HomeController@index", 'as' => 'c.home']);

    //登录等功能
    Route::group(['prefix'=>'auth'], function(){
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'c.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@loginPut", 'as' => 'c.auth.login.put']);
        Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'c.auth.logout']);
    });

    //食堂
    Route::group(['prefix'=>'canteen'], function(){
        Route::get('takeout', ['uses' => "CanteenController@takeout", 'as' => 'c.canteen.takeout']);
        Route::get('meal', ['uses' => "CanteenController@meal", 'as' => 'c.canteen.meal']);
    });

    //会员
    Route::group(['prefix'=>'member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'c.member']);
    });
});