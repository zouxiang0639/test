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
                'model'  => \App\Canteen\Bls\Users\Model\UsersModel::class,
            ],
        ],
    ],
];
