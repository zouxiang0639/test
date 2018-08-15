<?php
namespace App\Consts\Common;

class MealTypeConst
{
    const MORNING = 1;
    const LUNCH = 2;
    const DINNER = 3;

    const MORNING_DESC = '早餐';
    const LUNCH_DESC = '午餐';
    const DINNER_DESC = '晚餐';

    public static function desc()
    {
        return [
            self::MORNING => self::MORNING_DESC,
            self::LUNCH => self::LUNCH_DESC,
            self::DINNER => self::DINNER_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

    public static function priceDesc()
    {
        return [
            self::MORNING => config('config.morning_price'),
            self::LUNCH => config('config.lunch_price'),
            self::DINNER => config('config.dinner_price'),
        ];
    }

    public static function getPriceDesc($item)
    {
        return array_get(self::priceDesc(), $item);
    }
}