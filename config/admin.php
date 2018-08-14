<?php

return [

    //版本号
    'version' => 'v1.0-dev',

    /*
     * Laravel-admin name.
     */
    'name' => '食堂管理系统',

    /*
     * Logo in admin panel header.
     */
    'logo' => '<b>食堂管理系统</b>',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>系统</b>',

    /*
     * Laravel-admin html title.
     */
    'title' => '食堂管理',

    /*
     * Use `https`.
     */
    'secure' => false,

    /*
     * admin_config 数据库配置注入
     */
    'config' => env('ADMIN_CONFIG', false),

    //登录的背景图片
    'login_background_image' => '/admin/img/login_background.jpg',

    /*
     * Laravel-admin auth setting.
     */
    'auth' => [
        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => \App\Admin\Bls\Auth\Model\AdministratorModel::class,
            ],
        ],
    ],

    /*
     * @see https://adminlte.io/docs/2.4/layout
     */
    'skin' => 'skin-blue-light',

    /*
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
     */
    'layout' => ['sidebar-mini'],

    //数据库备份配置
    //'data_backup_part_size' => 20971520,
    'data_backup_part_size' => 209715200,
    'data_backup_compress' => 1,
    'data_backup_compress_level' => 9,
    'data_backup_import' => env('ADMIN_DATA_BACKUP_IMPORT', false), //是否开启导入数据库功能

];
