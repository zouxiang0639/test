<?php

namespace App\Consts\Admin\User;

class InfoTypeConst
{
    const REPLY = 1;
    const THUMBS_UP = 2;
    const RECOMMEND = 3;
    const VIOLATION = 4;
    const GREEN = 5;
    const FOREST_GREEN = 6;
    const RED = 7;


    const REPLY_DESC = '新增回复';
    const THUMBS_UP_DESC = '被点赞';
    const RECOMMEND_DESC = '被推荐';
    const VIOLATION_DESC = '违反';
    const GREEN_DESC = '萌萌新绿';
    const FOREST_GREEN_DESC = '森森满绿';
    const RED_DESC = '反对浅红';

    public static function desc()
    {
        return [
            self::REPLY => self::REPLY_DESC,
            self::THUMBS_UP => self::THUMBS_UP_DESC,
            self::RECOMMEND => self::RECOMMEND_DESC,
            self::VIOLATION => self::VIOLATION_DESC,
            self::GREEN => self::GREEN_DESC,
            self::FOREST_GREEN => self::FOREST_GREEN_DESC,
            self::RED => self::RED_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}