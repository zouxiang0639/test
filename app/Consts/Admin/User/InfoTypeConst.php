<?php

namespace App\Consts\Admin\User;

class InfoTypeConst
{
    const REPLY = 1;
    const THUMBS_UP = 2;
    const RECOMMEND = 3;
    const VIOLATION = 4;

    const REPLY_DESC = '评论';
    const THUMBS_UP_DESC = '点赞';
    const RECOMMEND_DESC = '推荐';
    const VIOLATION_DESC = '违反';

    public static function desc()
    {
        return [
            self::REPLY => self::REPLY_DESC,
            self::THUMBS_UP => self::THUMBS_UP_DESC,
            self::RECOMMEND => self::RECOMMEND_DESC,
            self::VIOLATION => self::VIOLATION_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}