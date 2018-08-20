<?php

namespace App\Consts\Admin\Other;

class AdvertTypeConst
{
    const ALL = 0;
    const BANNER = 1;
    const SQUARE = 2;

    const ALL_DESC = '全部';
    const BANNER_DESC = '长条广告';
    const SQUARE_DESC = '方形广告';

    public static function desc($arr = false)
    {

        $array =  [
            self::BANNER => self::BANNER_DESC,
            self::SQUARE => self::SQUARE_DESC,
        ];

        if($arr) {
            return array_merge([self::ALL => self::ALL_DESC], $array);
        }
        return $array;
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}