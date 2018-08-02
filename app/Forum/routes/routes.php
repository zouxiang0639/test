<?php

Route::group([
    'prefix'        => '/',
    'namespace'     => 'App\\Forum\\Controllers',
    'middleware'    => ['web', 'forum'],
], function(){


    Route::get('/', ['uses' => "HomeController@index", 'as' => 'f.home']);

    //文章
    Route::group(['prefix'=>'article'], function(){
        Route::get('list/{tag}', ['uses' => "ArticleController@index", 'as' => 'f.article.list']);
        Route::get('create', ['uses' => "ArticleController@create", 'as' => 'f.article.create']);
        Route::get('info/{id}', ['uses' => "ArticleController@info", 'as' => 'f.article.info']);

        Route::put('all', ['uses' => "ArticleController@all", 'as' => 'f.article.all']);

        Route::group(['middleware' => 'forum.auth:f_member'], function(){
            Route::put('thumbsup/{id}', ['uses' => "ArticleController@thumbsUp", 'as' => 'f.article.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ArticleController@thumbsDown", 'as' => 'f.article.thumbsDown']);

            Route::put('create/put', ['uses' => "ArticleController@createPut", 'as' => 'f.article.create.put']);
        });
    });

    //回复
    Route::group(['prefix'=>'reply'], function(){
        Route::put('show/child', ['uses' => "ReplyController@showChild", 'as' => 'f.reply.show.child']);
        Route::put('show/{article_id}', ['uses' => "ReplyController@show", 'as' => 'f.reply.show']);

        Route::group(['middleware' => 'forum.auth:f_member'], function(){
            Route::put('store', ['uses' => "ReplyController@store", 'as' => 'f.reply.store']);
            Route::delete('destroy/{id}', ['uses' => "ReplyController@destroy", 'as' => 'f.reply.destroy']);
            Route::put('thumbsup/{id}', ['uses' => "ReplyController@thumbsUp", 'as' => 'f.reply.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ReplyController@thumbsDown", 'as' => 'f.reply.thumbsDown']);
        });
    });

    //会员
    Route::group(['prefix'=>'member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'f.member.index']);
        Route::get('logout', ['uses' => "MemberController@create", 'as' => 'f.member.logout']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'f.member.info']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'f.member.reply']);
    });

    //登录等功能
    Route::group(['prefix'=>'auth'], function(){
        Route::get('qq', ['uses' => "AuthController@qq", 'as' => 'f.auth.qq']);
        Route::get('qq/login', ['uses' => "AuthController@qqLogin", 'as' => 'f.auth.qq.login']);
        Route::get('weibo', ['uses' => "AuthController@weibo", 'as' => 'f.auth.weibo']);
        Route::get('weibo/login', ['uses' => "AuthController@qqLogin", 'as' => 'f.auth.weibo.login']);
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'f.auth.login']);
        Route::put('login/put', ['uses' => "AuthController@loginPut", 'as' => 'f.auth.login.put']);
        Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'f.auth.logout']);
        Route::get('register', ['uses' => "AuthController@register", 'as' => 'f.auth.register']);
        Route::put('register/put', ['uses' => "AuthController@registerPut", 'as' => 'f.auth.register.put']);

    });

});


