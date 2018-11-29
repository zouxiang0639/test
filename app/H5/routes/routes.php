<?php

Route::group([
    'prefix'        => '/h5',
    'namespace'     => 'App\\H5\\Controllers',
    'middleware'    => ['web', 'forum'],
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'h.home']);
    //文章
    Route::group(['prefix'=>'article'], function(){
        Route::get('/', ['uses' => "ArticleController@index", 'as' => 'h.article.list']);
        Route::get('category', ['uses' => "ArticleController@category", 'as' => 'h.article.category']);
        Route::get('info/{id}', ['uses' => "ArticleController@info", 'as' => 'h.article.info']);


        Route::group(['middleware' => 'forum.auth:f_member'], function(){
            Route::put('thumbsup/{id}', ['uses' => "ArticleController@thumbsUp", 'as' => 'h.article.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ArticleController@thumbsDown", 'as' => 'h.article.thumbsDown']);
            Route::get('create', ['uses' => "ArticleController@create", 'as' => 'h.article.create']);
            Route::put('create/put', ['uses' => "ArticleController@createPut", 'as' => 'h.article.create.put']);
            Route::get('edit/{id}', ['uses' => "ArticleController@edit", 'as' => 'h.article.edit']);
            Route::put('edit/put/{id}', ['uses' => "ArticleController@editPut", 'as' => 'h.article.edit.put']);
            Route::put('star/{id}', ['uses' => "ArticleController@star", 'as' => 'h.article.star']);
            Route::put('recommend/{id}', ['uses' => "ArticleController@recommend", 'as' => 'h.article.recommend']);
            Route::delete('delete/{id}', ['uses' => "ArticleController@delete", 'as' => 'h.article.delete']);
        });
    });

    //回复
    Route::group(['prefix'=>'reply'], function(){
        Route::put('show/child', ['uses' => "ReplyController@showChild", 'as' => 'h.reply.show.child']);
        Route::put('show/{article_id}', ['uses' => "ReplyController@show", 'as' => 'h.reply.show']);

        Route::group(['middleware' => 'forum.auth:f_member'], function(){
            Route::put('store', ['uses' => "ReplyController@store", 'as' => 'h.reply.store']);
            Route::delete('destroy/{id}', ['uses' => "ReplyController@destroy", 'as' => 'h.reply.destroy']);
            Route::put('thumbsup/{id}', ['uses' => "ReplyController@thumbsUp", 'as' => 'h.reply.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ReplyController@thumbsDown", 'as' => 'h.reply.thumbsDown']);
        });
    });

    //空间
    Route::group(['prefix'=>'space'], function(){
        Route::get('index/{user_id}', ['uses' => "SpaceController@index", 'as' => 'h.space.index']);
        Route::get('reply/{user_id}', ['uses' => "SpaceController@reply", 'as' => 'h.space.reply']);
    });

    //会员
    Route::group(['prefix'=>'member', 'middleware' => 'forum.auth:f_member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'h.member.index']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'h.member.reply']);
        Route::get('recommend', ['uses' => "MemberController@recommend", 'as' => 'h.member.recommend']);
        Route::get('star', ['uses' => "MemberController@star", 'as' => 'h.member.star']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'h.member.info']);
        Route::put('info/sign', ['uses' => "MemberController@infoSign", 'as' => 'h.member.info.sign']);
        Route::put('sign/in', ['uses' => "MemberController@signIn", 'as' => 'h.member.sign.in']);

        Route::get('setup', ['uses' => "MemberController@setup", 'as' => 'h.member.setup']);
        Route::put('setup/basic', ['uses' => "MemberController@setupBasic", 'as' => 'h.member.setup.basic']);
        Route::put('setup/password', ['uses' => "MemberController@setupPassword", 'as' => 'h.member.setup.password']);
    });

    //登录等功能
    Route::group(['prefix'=>'auth'], function(){
        Route::get('info', ['uses' => "AuthController@info", 'as' => 'h.auth.info']);
        Route::get('login', ['uses' => "AuthController@login", 'as' => 'h.auth.login']);
        Route::get('logout', ['uses' => "AuthController@logout", 'as' => 'h.auth.logout']);
        Route::get('register', ['uses' => "AuthController@register", 'as' => 'h.auth.register']);
        Route::get('retrieve', ['uses' => "AuthController@retrieve", 'as' => 'h.auth.retrieve']);
    });
});


