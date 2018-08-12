<?php

Route::group([
    'prefix' => 'canteen',
    'namespace' => 'App\\Canteen\\Controllers',
    'middleware' => ['web', 'canteen'],
], function(){
    //登录等功能
    Route::group(['prefix'=>'auth'], function(){
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'c.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@loginPut", 'as' => 'c.auth.login.put']);
        Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'c.auth.logout']);
    });

    Route::group(['middleware' => 'canteen.auth:c_member'], function(){
        //食堂
        Route::group(['prefix'=>'canteen'], function(){
            Route::get('takeout', ['uses' => "CanteenController@takeout", 'as' => 'c.canteen.takeout']);
            Route::get('meal', ['uses' => "CanteenController@meal", 'as' => 'c.canteen.meal']);
            Route::put('takeout/buy', ['uses' => "CanteenController@takeoutBuy", 'as' => 'c.canteen.takeout.buy']);
        });

        //会员
        Route::group(['prefix'=>'member'], function(){
            Route::get('', ['uses' => "MemberController@index", 'as' => 'c.member']);
            Route::get('qrcode', ['uses' => "MemberController@qrCode", 'as' => 'c.qrcode']);
        });
    });
});