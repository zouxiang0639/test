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
        Route::get('gather', ['uses' => "ArticleController@gather", 'as' => 'f.article.gather']);
        Route::get('create', ['uses' => "ArticleController@create", 'as' => 'f.article.create']);
        Route::get('info/{id}', ['uses' => "ArticleController@info", 'as' => 'f.article.info']);
        Route::get('edit/{id}', ['uses' => "ArticleController@edit", 'as' => 'f.article.edit']);
        Route::put('all', ['uses' => "ArticleController@all", 'as' => 'f.article.all']);

        Route::group(['middleware' => 'forum.auth:f_member'], function(){
            Route::put('thumbsup/{id}', ['uses' => "ArticleController@thumbsUp", 'as' => 'f.article.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ArticleController@thumbsDown", 'as' => 'f.article.thumbsDown']);

            Route::put('create/put', ['uses' => "ArticleController@createPut", 'as' => 'f.article.create.put']);
            Route::put('edit/put/{id}', ['uses' => "ArticleController@editPut", 'as' => 'f.article.edit.put']);
            Route::put('star/{id}', ['uses' => "ArticleController@star", 'as' => 'f.article.star']);
            Route::put('recommend/{id}', ['uses' => "ArticleController@recommend", 'as' => 'f.article.recommend']);
            Route::delete('delete/{id}', ['uses' => "ArticleController@delete", 'as' => 'f.article.delete']);
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
    Route::group(['prefix'=>'member', 'middleware' => 'forum.auth:f_member'], function(){
        Route::get('', ['uses' => "MemberController@index", 'as' => 'f.member.index']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'f.member.reply']);
        Route::get('recommend', ['uses' => "MemberController@recommend", 'as' => 'f.member.recommend']);
        Route::get('star', ['uses' => "MemberController@star", 'as' => 'f.member.star']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'f.member.info']);
        Route::put('info/sign', ['uses' => "MemberController@infoSign", 'as' => 'f.member.info.sign']);
        Route::put('sign/in', ['uses' => "MemberController@signIn", 'as' => 'f.member.sign.in']);
    });

    //空间
    Route::group(['prefix'=>'space'], function(){
        Route::get('index/{user_id}', ['uses' => "SpaceController@index", 'as' => 'f.space.index']);
        Route::get('reply/{user_id}', ['uses' => "SpaceController@reply", 'as' => 'f.space.reply']);
    });

    //上传
    Route::group(['prefix'=>'upload', 'middleware' => 'forum.auth:f_member'], function(){

        Route::put('img', ['uses' => "UploadController@img", 'as' => 'f.upload.img']);
        Route::put('img/ckeditor', ['uses' => "UploadController@ckeditorImg", 'as' => 'f.upload.img.ckeditor']);
    });

    //反馈
    Route::group(['prefix'=>'feedback'], function(){

        Route::get('', ['uses' => "FeedbackController@feedback", 'as' => 'f.feedback.feedback']);
        Route::get('operate', ['uses' => "FeedbackController@operate", 'as' => 'f.feedback.operate']);
        Route::get('moderator', ['uses' => "FeedbackController@moderator", 'as' => 'f.feedback.moderator']);
        Route::get('appeals', ['uses' => "FeedbackController@appeals", 'as' => 'f.feedback.appeals']);
        Route::put('store', ['uses' => "FeedbackController@store", 'middleware' => 'forum.auth:f_member', 'as' => 'f.feedback.store']);
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
        Route::put('email/auth', ['uses' => "AuthController@emailAuth", 'as' => 'f.auth.email.auth']);
        Route::put('check/name', ['uses' => "AuthController@checkName", 'as' => 'f.auth.check.name']);

    });

});


