<?php

namespace App\Consts\Admin\User;

class InfoTypeConst
{
    const AT = 1;
    const ARTICLE_REPLY = 2;
    const THUMBS_UP = 3;
    const SYSTEM = 4;

    const AT_DESC = '提到我的';
    const ARTICLE_REPLY_DESC = '帖子回复';
    const THUMBS_UP_DESC = '被赞';
    const SYSTEM_DESC = '系统';
    const RECOMMEND_DESC = '被推荐';
    const VIOLATION_DESC = '违反';
    const GREEN_DESC = '萌萌新绿';
    const FOREST_GREEN_DESC = '森森满绿';
    const RED_DESC = '反对浅红';

    public static function desc()
    {
        return [
            self::AT => self::AT_DESC,
            self::ARTICLE_REPLY => self::ARTICLE_REPLY_DESC,
            self::THUMBS_UP => self::THUMBS_UP_DESC,
            self::SYSTEM => self::SYSTEM_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}