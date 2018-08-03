<?php

return [

    /*
     * Laravel-admin name.
     */
    'name' => 'Laravel-admin',

    /*
     * Logo in admin panel header.
     */
    'logo' => '<b>Laravel</b> admin',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>La</b>',

    /*
     * Laravel-admin html title.
     */
    'title' => 'Admin',

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

    /*
     * Version displayed in footer.
     */
    'version' => 'v1.0-dev',


];
