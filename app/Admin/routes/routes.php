<?php

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\\Admin\\Controllers',
    'middleware' => ['web', 'admin'],
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "Auth\\AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "Auth\\AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "Auth\\AuthController@logout", 'as' => 'm.logout']);
    Route::get('setting', ['uses' => "Auth\\AuthController@setting", 'as' => 'm.setting']);
    Route::post('setting/update', ['uses' => "Auth\\AuthController@settingUpdate", 'as' => 'm.setting.update']);
    Route::get('auth/users', ['uses' => "Auth\\AuthController@index", 'as' => 'm.auth.users']);

    //后台管理
    Route::group(['prefix'=>'auth'], function(){
        //后台管理员
        Route::group(['prefix'=>'users', 'middleware' => 'admin.auth:m_auth_users'], function(){
            Route::get('', ['uses' => "Auth\\UserController@index", 'as' => 'm.user.list']);
            Route::get('create', ['uses' => "Auth\\UserController@create", 'as' => 'm.user.create']);
            Route::post('store', ['uses' => "Auth\\UserController@store", 'as' => 'm.user.store']);
            Route::get('edit/{id}', ['uses' => "Auth\\UserController@edit", 'as' => 'm.user.edit']);
            Route::post('update/{id}', ['uses' => "Auth\\UserController@update", 'as' => 'm.user.update']);
            Route::delete('destroy/{id}', ['uses' => "Auth\\UserController@destroy", 'as' => 'm.user.destroy']);
        });

        //角色
        Route::group(['prefix'=>'role', 'middleware' => 'admin.auth:m_auth_role'], function(){
            Route::get('', ['uses' => "Auth\\RoleController@index", 'as' => 'm.role.list']);
            Route::get('edit/{id}', ['uses' => "Auth\\RoleController@edit", 'as' => 'm.role.edit']);
            Route::post('update/{id}', ['uses' => "Auth\\RoleController@update", 'as' => 'm.role.update']);
            Route::get('create', ['uses' => "Auth\\RoleController@create", 'as' => 'm.role.create']);
            Route::post('store', ['uses' => "Auth\\RoleController@store", 'as' => 'm.role.store']);
            Route::delete('destroy/{id}', ['uses' => "Auth\\RoleController@destroy", 'as' => 'm.role.destroy']);
        });

        //权限
        Route::group(['prefix'=>'permissions', 'middleware' => 'admin.auth:m_auth_permissions'], function(){
            Route::get('', ['uses' => "Auth\\PermissionsController@index", 'as' => 'm.permissions.list']);
            Route::get('/create', ['uses' => "Auth\\PermissionsController@create", 'as' => 'm.permissions.create']);
            Route::post('store', ['uses' => "Auth\\PermissionsController@store", 'as' => 'm.permissions.store']);
            Route::get('edit/{id}', ['uses' => "Auth\\PermissionsController@edit", 'as' => 'm.permissions.edit']);
            Route::post('update/{id}', ['uses' => "Auth\\PermissionsController@update", 'as' => 'm.permissions.update']);
            Route::delete('destroy/{id}', ['uses' => "Auth\\PermissionsController@destroy", 'as' => 'm.permissions.destroy']);
        });

        //菜单
        Route::group(['prefix'=>'menu', 'middleware' => 'admin.auth:m_auth_menu'], function(){
            Route::get('', ['uses' => "Auth\\MenuController@index", 'as' => 'm.menu.list']);
            Route::post('store', ['uses' => "Auth\\MenuController@store", 'as' => 'm.menu.store']);
            Route::get('edit/{id}', ['uses' => "Auth\\MenuController@edit", 'as' => 'm.menu.edit']);
            Route::post('update/{id}', ['uses' => "Auth\\MenuController@update", 'as' => 'm.menu.update']);
            Route::post('sort', ['uses' => "Auth\\MenuController@sort", 'as' => 'm.menu.sort']);
            Route::delete('destroy/{id}', ['uses' => "Auth\\MenuController@destroy", 'as' => 'm.menu.destroy']);
        });

    });

    //其他管理
    Route::group(['prefix'=>'other'], function(){

        //用户反馈
        Route::group(['prefix'=>'feedback', 'middleware' => 'admin.auth:m_other_feedback'], function(){
            Route::get('', ['uses' => "Other\\FeedbackController@index", 'as' => 'm.other.feedback.list']);
            Route::get('show/{id}', ['uses' => "Other\\FeedbackController@show", 'as' => 'm.other.feedback.show']);
        });

        //广告
        Route::group(['prefix'=>'advert', 'middleware' => 'admin.auth:m_other_advert'], function(){
            Route::get('', ['uses' => "Other\\AdvertController@index", 'as' => 'm.other.advert.list']);
            Route::get('/create', ['uses' => "Other\\AdvertController@create", 'as' => 'm.other.advert.create']);
            Route::post('store', ['uses' => "Other\\AdvertController@store", 'as' => 'm.other.advert.store']);
            Route::get('edit/{id}', ['uses' => "Other\\AdvertController@edit", 'as' => 'm.other.advert.edit']);
            Route::post('update/{id}', ['uses' => "Other\\AdvertController@update", 'as' => 'm.other.advert.update']);
            Route::delete('destroy/{id}', ['uses' => "Other\\AdvertController@destroy", 'as' => 'm.other.advert.destroy']);
            Route::put('status/{id}', ['uses' => "Other\\AdvertController@status", 'as' => 'm.other.advert.status']);
            Route::put('hot', ['uses' => "Other\\AdvertController@hot", 'as' => 'm.other.advert.hot']);
        });

        //碎片
        Route::group(['prefix'=>'fragment', 'middleware' => 'admin.auth:m_other_fragment'], function(){
            Route::get('', ['uses' => "Other\\FragmentController@index", 'as' => 'm.other.fragment.list']);
            Route::get('/create', ['uses' => "Other\\FragmentController@create", 'as' => 'm.other.fragment.create']);
            Route::post('store', ['uses' => "Other\\FragmentController@store", 'as' => 'm.other.fragment.store']);
            Route::get('edit/{id}', ['uses' => "Other\\FragmentController@edit", 'as' => 'm.other.fragment.edit']);
            Route::post('update/{id}', ['uses' => "Other\\FragmentController@update", 'as' => 'm.other.fragment.update']);
            Route::delete('destroy/{id}', ['uses' => "Other\\FragmentController@destroy", 'as' => 'm.other.fragment.destroy']);
            Route::put('status/{id}', ['uses' => "Other\\FragmentController@status", 'as' => 'm.other.fragment.status']);
            Route::put('hot', ['uses' => "Other\\FragmentController@hot", 'as' => 'm.other.advert.hot']);
        });
    });

    //系统管理
    Route::group(['prefix'=>'system'], function(){

        //上传文件
        Route::group(['prefix'=>'upload'], function(){
            Route::put('image', ['uses' => "System\\UploadController@image", 'as' => 'm.system.upload.image']);
            Route::put('ckeditor', ['uses' => "System\\UploadController@ckeditor", 'as' => 'm.system.upload.ckeditor']);
        });

        //配置
        Route::group(['prefix'=>'config', 'middleware' => 'admin.auth:m_system_config'], function(){
            Route::get('', ['uses' => "System\\ConfigController@index", 'as' => 'm.system.config.list']);
            Route::get('/create', ['uses' => "System\\ConfigController@create", 'as' => 'm.system.config.create']);
            Route::post('store', ['uses' => "System\\ConfigController@store", 'as' => 'm.system.config.store']);
            Route::get('edit/{id}', ['uses' => "System\\ConfigController@edit", 'as' => 'm.system.config.edit']);
            Route::post('update/{id}', ['uses' => "System\\ConfigController@update", 'as' => 'm.system.config.update']);
            Route::delete('destroy/{id}', ['uses' => "System\\ConfigController@destroy", 'as' => 'm.system.config.destroy']);
            Route::get('/set', ['uses' => "System\\ConfigController@set", 'as' => 'm.system.config.set']);
            Route::post('/set', ['uses' => "System\\ConfigController@setPost", 'as' => 'm.system.config.set.post']);
            Route::post('/sensitive', ['uses' => "System\\ConfigController@sensitive", 'as' => 'm.system.config.sensitive']);
        });

        //标签
        Route::group(['prefix'=>'tags', 'middleware' => 'admin.auth:m_system_tags'], function(){
            Route::get('', ['uses' => "System\\TagsController@index", 'as' => 'm.system.tags.list']);
            Route::get('/create', ['uses' => "System\\TagsController@create", 'as' => 'm.system.tags.create']);
            Route::post('store', ['uses' => "System\\TagsController@store", 'as' => 'm.system.tags.store']);
            Route::get('edit/{id}', ['uses' => "System\\TagsController@edit", 'as' => 'm.system.tags.edit']);
            Route::post('update/{id}', ['uses' => "System\\TagsController@update", 'as' => 'm.system.tags.update']);
            Route::delete('destroy/{id}', ['uses' => "System\\TagsController@destroy", 'as' => 'm.system.tags.destroy']);
            Route::put('status/{id}', ['uses' => "System\\TagsController@status", 'as' => 'm.system.tags.status']);
            Route::put('hot', ['uses' => "System\\TagsController@hot", 'as' => 'm.system.tags.hot']);
        });

        //系统日志
        Route::group(['prefix'=>'log', 'middleware' => 'admin.auth:m_system_log'], function(){
            Route::get('', ['uses' => "System\\LogController@index", 'as' => 'm.system.log.list']);
        });

        //数据空备份
        Route::group(['prefix'=>'backup', 'middleware' => 'admin.auth:m_system_backup'], function(){
            Route::get('', ['uses' => "System\\BackupController@index", 'as' => 'm.system.backup.list']);
            Route::post('export', ['uses' => "System\\BackupController@export", 'as' => 'm.system.backup.export']);
            Route::put('export', ['uses' => "System\\BackupController@exportPut", 'as' => 'm.system.backup.export.put']);
            Route::post('optimize', ['uses' => "System\\BackupController@optimize", 'as' => 'm.system.backup.optimize']);
            Route::post('repair', ['uses' => "System\\BackupController@repair", 'as' => 'm.system.backup.repair']);
            Route::get('file', ['uses' => "System\\BackupController@file", 'as' => 'm.system.backup.file']);
            Route::delete('destroy/{file}', ['uses' => "System\\BackupController@destroy", 'as' => 'm.system.backup.destroy']);
            Route::get('download/{file}', ['uses' => "System\\BackupController@download", 'as' => 'm.system.backup.download']);

            if(config('admin.data_backup_import')) {
                Route::post('import', ['uses' => "System\\BackupController@import", 'as' => 'm.system.backup.import']);
                Route::put('import', ['uses' => "System\\BackupController@importPut", 'as' => 'm.system.backup.import.put']);
            }
        });

    });

    //示例
    Route::group(['prefix'=>'demo'], function(){
        Route::get('form', ['uses' => "Demo\\WidgetsController@form", 'as' => 'm.demo.form']);
        Route::post('formPost', ['uses' => "Demo\\WidgetsController@formPost", 'as' => 'm.demo.widgets.formPost']);
        Route::post('select/search', ['uses' => "Demo\\WidgetsController@selectSearch", 'as' => 'm.demo.widgets.select.search']);
    });

    //用户管理
    Route::group(['prefix'=>'customer'], function(){

        //用户
        Route::group(['prefix'=>'users', 'middleware' => 'admin.auth:m_customer_users'], function(){
            Route::get('', ['uses' => "Customer\\UsersController@index", 'as' => 'm.customer.users.list']);
            Route::get('edit/{id}', ['uses' => "Customer\\UsersController@edit", 'as' => 'm.customer.users.edit']);
            Route::post('update/{id}', ['uses' => "Customer\\UsersController@update", 'as' => 'm.customer.users.update']);
            Route::put('status/{id}', ['uses' => "Customer\\UsersController@status", 'as' => 'm.customer.users.status']);
            Route::put('excuse/{id}', ['uses' => "Customer\\UsersController@excuse", 'as' => 'm.customer.users.excuse']);
        });

    });

    //内容管理
    Route::group(['prefix'=>'contents'], function(){
        //公告
        Route::group(['prefix'=>'notice', 'middleware' => 'admin.auth:m_contents_notice'], function(){
            Route::get('', ['uses' => "Contents\\NoticeController@index", 'as' => 'm.contents.notice.list']);
            Route::get('/create', ['uses' => "Contents\\NoticeController@create", 'as' => 'm.contents.notice.create']);
            Route::post('store', ['uses' => "Contents\\NoticeController@store", 'as' => 'm.contents.notice.store']);
            Route::get('edit/{id}', ['uses' => "Contents\\NoticeController@edit", 'as' => 'm.contents.notice.edit']);
            Route::post('update/{id}', ['uses' => "Contents\\NoticeController@update", 'as' => 'm.contents.notice.update']);
            Route::put('status/{id}', ['uses' => "Contents\\NoticeController@status", 'as' => 'm.contents.notice.status']);
            Route::delete('destroy/{id}', ['uses' => "Contents\\NoticeController@destroy", 'as' => 'm.contents.notice.destroy']);
        });

        //文章
        Route::group(['prefix'=>'article', 'middleware' => 'admin.auth:m_contents_article'], function(){
            Route::get('', ['uses' => "Contents\\ArticleController@index", 'as' => 'm.contents.article.list']);
            Route::get('edit/{id}', ['uses' => "Contents\\ArticleController@edit", 'as' => 'm.contents.article.edit']);
            Route::post('update/{id}', ['uses' => "Contents\\ArticleController@update", 'as' => 'm.contents.article.update']);
            Route::put('status/{id}', ['uses' => "Contents\\ArticleController@status", 'as' => 'm.contents.article.status']);
            Route::delete('destroy/{id}', ['uses' => "Contents\\ArticleController@destroy", 'as' => 'm.contents.article.destroy']);
            Route::put('reduction/{id}', ['uses' => "Contents\\ArticleController@reduction", 'as' => 'm.contents.article.reduction']);
            Route::put('hot/search/{id}', ['uses' => "Contents\\ArticleController@hotSearch", 'as' => 'm.contents.article.hot.search']);
        });

        //评论
        Route::group(['prefix'=>'reply', 'middleware' => 'admin.auth:m_contents_reply'], function(){
            Route::get('', ['uses' => "Contents\\ReplyController@index", 'as' => 'm.contents.reply.list']);
            Route::delete('destroy/{id}', ['uses' => "Contents\\ReplyController@destroy", 'as' => 'm.contents.reply.destroy']);
            Route::put('reduction/{id}', ['uses' => "Contents\\ReplyController@reduction", 'as' => 'm.contents.reply.reduction']);
        });

        //文件
        Route::group(['prefix'=>'file', 'middleware' => 'admin.auth:m_contents_file'], function(){
            Route::get('', ['uses' => "Contents\\FileController@index", 'as' => 'm.contents.file.list']);
            Route::delete('destroy/{id}', ['uses' => "Contents\\FileController@destroy", 'as' => 'm.contents.file.destroy']);
        });

    });

});


