<?php
namespace App\Consts\Common;

class FileTypeConst
{
    const IMG = 1;
    const MOVIE = 2;

    const IMG_DESC = '图片';
    const MOVIE_DESC = '视屏';

    public static function desc()
    {
        return [
            self::IMG => self::IMG_DESC,
            self::MOVIE => self::MOVIE_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }
}