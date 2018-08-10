<?php

namespace App\Library\Format;

/**
 * Class FormatMoney
 * @package App\Library\Common
 */
class FormatMoney
{
    /**
     * 元转分
     * @param $yuan
     * @return int
     */
    public static function yuan2fen($yuan)
    {
        return intval(bcmul($yuan, 100));
    }

    /**
     * 分格式化
     * @param $fen
     * @return string
     */
    public static function fen2yuan($fen,$separator=',')
    {
        return number_format(bcdiv($fen, 100, 2), 2, '.', $separator);
    }

    /**
     * 元格式化
     * @param $yuan
     * @param string $separator
     * @return string
     */
    public static function yuan($yuan, $separator=','){
        return number_format($yuan, 2, '.', $separator);
    }

    /**
     * 字符串钱转分整型
     * @param $yuan
     * @param string $separator
     * @return int
     */
    public static function fen($yuan, $separator=',')
    {
        return static::yuan2fen(str_replace($separator, '', $yuan));
    }
}