<?php

return [

    /*
     * Laravel-admin auth setting.
     */
    'auth' => [
        'guards' => [
            'canteen' => [
                'driver'   => 'session',
                'provider' => 'canteen',
            ],
        ],

        'providers' => [
            'canteen' => [
                'driver' => 'eloquent',
                'model'  => \App\Admin\Bls\Auth\Model\AdministratorModel::class,
            ],
        ],
    ],
];
