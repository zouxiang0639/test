<?php

Route::group([
    'prefix'        => 'forum',
    'namespace'     => 'App\\Forum\\Controllers',
    'middleware'    => ['web', 'forum'],
], function(){


    Route::get('/', ['uses' => "HomeController@index", 'as' => 'f.home']);
    Route::group(['prefix'=>'article'], function(){
        Route::get('list/{tag}', ['uses' => "ArticleController@index", 'as' => 'f.article.list']);
        Route::get('create', ['uses' => "ArticleController@create", 'as' => 'f.article.create']);
        Route::put('create/put', ['uses' => "ArticleController@createPut", 'as' => 'f.article.create.put']);
        Route::get('info/{id}', ['uses' => "ArticleController@info", 'as' => 'f.article.info']);

        Route::put('thumbsup/{id}', ['uses' => "ArticleController@thumbsUp", 'as' => 'f.article.thumbsUp']);
        Route::put('thumbsdown/{id}', ['uses' => "ArticleController@thumbsDown", 'as' => 'f.article.thumbsDown']);
    });

    Route::group(['prefix'=>'member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'f.member.index']);
        Route::get('logout', ['uses' => "MemberController@create", 'as' => 'f.member.logout']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'f.member.info']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'f.member.reply']);
    });
    Route::group(['prefix'=>'auth'], function(){
        Route::get('qq', ['uses' => "AuthController@qq", 'as' => 'f.auth.qq']);
        Route::get('qq/login', ['uses' => "AuthController@qqLogin", 'as' => 'f.auth.qq.login']);
        Route::get('weibo', ['uses' => "AuthController@weibo", 'as' => 'f.auth.weibo']);
        Route::get('weibo/login', ['uses' => "AuthController@qqLogin", 'as' => 'f.auth.weibo.login']);
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'f.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@loginPut", 'as' => 'f.auth.login.put']);
        Route::get('register', ['uses' => "AuthController@register", 'as' => 'f.auth.register']);
        Route::put('register/put', ['uses' => "AuthController@registerPut", 'as' => 'f.auth.register.put']);
    });

});


