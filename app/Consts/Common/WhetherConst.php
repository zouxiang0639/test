<?php
namespace App\Consts\Common;

class WhetherConst
{
    const YES = 1;
    const NO = 2;

    const YES_DESC = '是';
    const NO_DESC = '否';

    public static function desc()
    {
        return [
            self::YES => self::YES_DESC,
            self::NO => self::NO_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }
}