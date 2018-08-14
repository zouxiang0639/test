<?php

namespace App\Consts\Admin\Other;

class AdvertTypeConst
{
    const ALL = 0;
    const BANNER = 1;

    const ALL_DESC = '全部';
    const BANNER_DESC = '幻灯片';

    public static function desc($arr = false)
    {

        $array =  [
            self::BANNER => self::BANNER_DESC,
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