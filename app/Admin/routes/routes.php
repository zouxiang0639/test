<?php

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "Auth\\AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "Auth\\AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "Auth\\AuthController@logout", 'as' => 'm.logout']);
    Route::get('setting', ['uses' => "Auth\\AuthController@setting", 'as' => 'm.setting']);
    Route::post('setting/update', ['uses' => "Auth\\AuthController@settingUpdate", 'as' => 'm.setting.update']);
    Route::get('auth/users', ['uses' => "Auth\\AuthController@index", 'as' => 'm.auth.users']);

    //后台管理员
    Route::group(['prefix'=>'users', 'middleware' => 'admin.auth:m_users'], function(){
        Route::get('', ['uses' => "Auth\\UserController@index", 'as' => 'm.user.list']);
        Route::get('create', ['uses' => "Auth\\UserController@create", 'as' => 'm.user.create']);
        Route::post('store', ['uses' => "Auth\\UserController@store", 'as' => 'm.user.store']);
        Route::get('edit/{id}', ['uses' => "Auth\\UserController@edit", 'as' => 'm.user.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\UserController@update", 'as' => 'm.user.update']);
    });

    //角色
    Route::group(['prefix'=>'role', 'middleware' => 'admin.auth:m_role'], function(){
        Route::get('', ['uses' => "Auth\\RoleController@index", 'as' => 'm.role.list']);
        Route::get('edit/{id}', ['uses' => "Auth\\RoleController@edit", 'as' => 'm.role.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\RoleController@update", 'as' => 'm.role.update']);
        Route::get('create', ['uses' => "Auth\\RoleController@create", 'as' => 'm.role.create']);
        Route::post('store', ['uses' => "Auth\\RoleController@store", 'as' => 'm.role.store']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\RoleController@destroy", 'as' => 'm.role.destroy']);
    });

    //权限
    Route::group(['prefix'=>'permissions'], function(){
        Route::get('', ['uses' => "Auth\\PermissionsController@index", 'as' => 'm.permissions.list']);
        Route::get('/create', ['uses' => "Auth\\PermissionsController@create", 'as' => 'm.permissions.create']);
        Route::post('store', ['uses' => "Auth\\PermissionsController@store", 'as' => 'm.permissions.store']);
        Route::get('edit/{id}', ['uses' => "Auth\\PermissionsController@edit", 'as' => 'm.permissions.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\PermissionsController@update", 'as' => 'm.permissions.update']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\PermissionsController@destroy", 'as' => 'm.permissions.destroy']);
    });

    //菜单
    Route::group(['prefix'=>'menu', 'middleware' => 'admin.auth:m_menu'], function(){
        Route::get('', ['uses' => "Auth\\MenuController@index", 'as' => 'm.menu.list']);
        Route::post('store', ['uses' => "Auth\\MenuController@store", 'as' => 'm.menu.store']);
        Route::get('edit/{id}', ['uses' => "Auth\\MenuController@edit", 'as' => 'm.menu.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\MenuController@update", 'as' => 'm.menu.update']);
        Route::post('sort', ['uses' => "Auth\\MenuController@sort", 'as' => 'm.menu.sort']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\MenuController@destroy", 'as' => 'm.menu.destroy']);
    });

    //示例
    Route::group(['prefix'=>'demo'], function(){
        Route::get('form', ['uses' => "Demo\\WidgetsController@form", 'as' => 'm.demo.form']);
        Route::post('formPost', ['uses' => "Demo\\WidgetsController@formPost", 'as' => 'm.demo.widgets.formPost']);
    });

    //系统
    Route::group(['prefix'=>'system'], function(){
        Route::put('upload/image', ['uses' => "System\\UploadController@image", 'as' => 'm.system.upload.image']);

        //配置
        Route::group(['prefix'=>'config'], function(){
            Route::get('', ['uses' => "System\\ConfigController@index", 'as' => 'm.system.config.list']);
            Route::get('/create', ['uses' => "System\\ConfigController@create", 'as' => 'm.system.config.create']);
            Route::post('store', ['uses' => "System\\ConfigController@store", 'as' => 'm.system.config.store']);
            Route::get('edit/{id}', ['uses' => "System\\ConfigController@edit", 'as' => 'm.system.config.edit']);
            Route::post('update/{id}', ['uses' => "System\\ConfigController@update", 'as' => 'm.system.config.update']);
            Route::delete('destroy/{id}', ['uses' => "System\\ConfigController@destroy", 'as' => 'm.system.config.destroy']);
        });
    });


});


