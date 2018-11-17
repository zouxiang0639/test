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
            Route::put('thumbsup/{id}', ['uses' => "ArticleController@thumbsUp", 'as' => 'f.article.thumbsUp']);
            Route::put('thumbsdown/{id}', ['uses' => "ArticleController@thumbsDown", 'as' => 'f.article.thumbsDown']);
            Route::put('create/put', ['uses' => "ArticleController@createPut", 'as' => 'f.article.create.put']);
            Route::put('edit/put/{id}', ['uses' => "ArticleController@editPut", 'as' => 'f.article.edit.put']);
            Route::put('star/{id}', ['uses' => "ArticleController@star", 'as' => 'f.article.star']);
            Route::put('recommend/{id}', ['uses' => "ArticleController@recommend", 'as' => 'f.article.recommend']);
            Route::delete('delete/{id}', ['uses' => "ArticleController@delete", 'as' => 'f.article.delete']);
        });
    });
});


