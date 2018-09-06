<?php

namespace App\Consts\Admin\Other;

class AdvertTypeConst
{
    const ALL = 0;
    const BANNER = 1;
    const SQUARE = 2;
    const REPLY_AD = 3;

    const ALL_DESC = '全部';
    const BANNER_DESC = '长条广告';
    const SQUARE_DESC = '方形广告';
    const REPLY_AD_DESC = '评论广告';

    public static function desc($arr = false)
    {

        $array =  [
            self::BANNER => self::BANNER_DESC,
            self::SQUARE => self::SQUARE_DESC,
            self::REPLY_AD => self::REPLY_AD_DESC,
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