<?php

Route::group(['middleware' => 'api.aes:contents'], function(){

    //用户
    Route::group(['prefix'=>'user'], function(){
        Route::post('register', ['uses' => "UsersController@register"]);
        Route::post('show', ['uses' => "UsersController@show"]);
        Route::post('login', ['uses' => "UsersController@login"]);
    });

    //订单
    Route::group(['prefix'=>'order'], function(){
        Route::post('meal', 'OrderController@meal');
        Route::post('takeout', 'OrderController@takeout');
        Route::post('payment', 'OrderController@payment');
    });

    //现场支付
    Route::group(['prefix'=>'site'], function(){
        Route::post('payment', 'SiteController@payment');
    });

    //标签
    Route::group(['prefix'=>'tags'], function(){
        Route::post('group', ['uses' => "TagsController@group"]);
    });
});
