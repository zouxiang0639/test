<?php

namespace App\Library\Forum\Facades;

use Illuminate\Support\Facades\Facade;

class Forum extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'forum';
    }
}
