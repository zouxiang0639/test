<?php

namespace App\Forum\Bls\Article\Traits;


trait ThumbsTraits
{

    protected static function thumbsMinus($array, $userId)
    {
        $key = array_search($userId, $array);
        unset($array[$key]);

        return $array;
    }

    protected static function thumbsPlus($array, $userId)
    {
        return array_merge($array, [$userId]);
    }

    protected static function checkThumbs($minus, $plus, $userId)
    {
        return in_array($userId, $minus) ||  in_array($userId, $plus);
    }
}