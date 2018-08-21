<?php

Route::group([], function(){

    //用户
    Route::group(['prefix'=>'user'], function(){
        Route::post('register', ['uses' => "UsersController@register", 'middleware' => 'api.aes:contents']);
    });

    //订单
    Route::group(['prefix'=>'order'], function(){
        Route::get('', 'OrderController@register');
    });

    //标签
    Route::group(['prefix'=>'tags'], function(){
        Route::post('group', ['uses' => "TagsController@group"]);
    });
});
