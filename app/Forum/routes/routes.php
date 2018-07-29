<?php

Route::group([
    'prefix'        => 'forum',
    'namespace'     => 'App\\Forum\\Controllers',
    'middleware'    => ['web', 'forum'],
], function(){


    Route::get('/', ['uses' => "HomeController@index", 'as' => 'f.home']);
    Route::group(['prefix'=>'article'], function(){
        Route::get('list/{id}', ['uses' => "ArticleController@index", 'as' => 'f.article.list']);
        Route::get('create', ['uses' => "ArticleController@create", 'as' => 'f.article.create']);
        Route::get('info', ['uses' => "ArticleController@info", 'as' => 'f.article.info']);
    });

    Route::group(['prefix'=>'member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'f.member.index']);

        Route::get('logout', ['uses' => "MemberController@create", 'as' => 'f.member.logout']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'f.member.info']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'f.member.reply']);
    });
    Route::group(['prefix'=>'auth'], function(){
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'f.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@index", 'as' => 'f.auth.login.put']);
        Route::get('register', ['uses' => "AuthController@register", 'as' => 'f.auth.register']);
        Route::put('register/put', ['uses' => "AuthController@registerPut", 'as' => 'f.auth.register.put']);
    });

});


