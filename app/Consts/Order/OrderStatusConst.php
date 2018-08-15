<?php
namespace App\Consts\Order;

/**
 * 订单状态
 * Created by OrderStatusConst.
 * @author: zouxiang
 * @date:
 */
class OrderStatusConst
{
    const DEPOSIT = 1;
    const PAYMENT = 2;
    const ACCESS = 3;
    const FINISH = 4;
    const REFUND = 5;
    const OVERDUE = 6;

    const DEPOSIT_DESC = '已支付定金';
    const PAYMENT_DESC = '全额支付';
    const ACCESS_DESC = '待评价';
    const FINISH_DESC = '完成';
    const REFUND_DESC = '退单';
    const OVERDUE_DESC = '过期';

    public static function desc()
    {
        return [
            self::DEPOSIT => self::DEPOSIT_DESC,
            self::PAYMENT => self::PAYMENT_DESC,
            self::ACCESS => self::ACCESS_DESC,
            self::FINISH => self::FINISH_DESC,
            self::REFUND => self::REFUND_DESC,
            self::OVERDUE => self::OVERDUE_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }
}