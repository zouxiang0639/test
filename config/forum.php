<?php

return [
    /*
     * Laravel-admin auth setting.
     */
    'auth' => [
        'guards' => [
            'forum' => [
                'driver'   => 'session',
                'provider' => 'forum',
            ],
        ],

        'providers' => [
            'forum' => [
                'driver' => 'eloquent',
                'model'  => \App\Admin\Bls\Auth\Model\AdministratorModel::class,
            ],
        ],
    ],


];
