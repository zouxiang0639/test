<?php

namespace App\Consts\Admin\Other;

class FeedbackTypeConst
{
    const ALL = 0;
    const FEEDBACK = 1;

    const ALL_DESC = '全部';
    const FEEDBACK_DESC = '评论';

    public static function desc()
    {
        return [
            self::ALL => self::ALL_DESC,
            self::FEEDBACK => self::FEEDBACK_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}