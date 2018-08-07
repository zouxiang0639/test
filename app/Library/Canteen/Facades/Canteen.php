<?php

namespace App\Library\Canteen\Facades;

use Illuminate\Support\Facades\Facade;

class Canteen extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin';
    }
}
