<?php
namespace App\Consts\Order;

/**
 * 订单类型
 * Created by OrderTypeConst.
 * @author: zouxiang
 * @date:
 */
class OrderTypeConst
{
    const MEAL = 1;
    const TAKEOUT = 2;


    const MEAL_DESC = '点餐';
    const TAKEOUT_DESC = '外卖';


    public static function desc()
    {
        return [
            self::MEAL => self::MEAL_DESC,
            self::TAKEOUT => self::TAKEOUT_DESC
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }
}