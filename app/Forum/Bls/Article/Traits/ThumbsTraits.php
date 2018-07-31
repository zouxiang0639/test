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
}