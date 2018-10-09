<?php
namespace App\Consts\Common;

class SearchType
{
    const TITLE = 1;
    const NAME = 2;

    const TITLE_DESC = '标题';
    const NAME_DESC = '作者';

    public static function desc()
    {
        return [
            self::TITLE => self::TITLE_DESC,
            self::NAME => self::NAME_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }
}