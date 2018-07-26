<?php

namespace App\Consts\Admin\Tags;

class TagsTypeConst
{
    const TAG = 1;

    const TAG_DESC = '标签';

    public static function desc()
    {
        return [
            self::TAG => self::TAG_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}