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
        Route::get('login', ['uses' => "MemberController@login", 'as' => 'f.member.login']);
        Route::put('login/put', ['uses' => "MemberController@index", 'as' => 'f.member.login.put']);
        Route::get('register', ['uses' => "MemberController@register", 'as' => 'f.member.register']);
        Route::get('logout', ['uses' => "MemberController@create", 'as' => 'f.member.logout']);
        Route::get('info', ['uses' => "MemberController@info", 'as' => 'f.member.info']);
        Route::get('reply', ['uses' => "MemberController@reply", 'as' => 'f.member.reply']);
    });

});


