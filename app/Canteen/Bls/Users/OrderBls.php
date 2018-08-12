<?php

namespace App\Canteen\Bls\Users;

use App\Canteen\Bls\Canteen\TakeoutBls;
use App\Canteen\Bls\Users\Model\OrderModel;
use App\Canteen\Bls\Users\Model\OrderTakeoutModel;
use App\Consts\Common\AccountFlowConst;
use App\Consts\Order\OrderStatusConst;
use Auth;

class OrderBls
{

    /**
     * 外面订单创建
     * @param $data
     * @param $amount
     * @param $deposit
     * @return mixed
     */
    public static function createTakeoutOrder($data, $amount, $deposit)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($data, $amount, $deposit) {
            $user = Auth::guard('canteen')->user();
            $user->money -= $deposit;

            $order = new OrderModel();
            $order->user_id = $user->id;
            $order->amount = $amount;
            $order->deposit = $deposit;
            $order->status = OrderStatusConst::DEPOSIT;
            $order->title = date('Ymd').'外卖';
            $order->save();

            foreach($data as $item){
                static::createTakeoutOrderByChild($item, $order->id);
            }

            AccountFlowBls::createAccountFlow($user->id, AccountFlowConst::PAYMENT, $deposit, "支付{$order->title}定金");

            return $user->save();
        });
    }

    /**
     *
     * 外面订单关联创建
     * @param $data
     * @param $orderID
     * @return bool
     */
    private static function createTakeoutOrderByChild($data, $orderID)
    {

        $model = new OrderTakeoutModel();
        $model->order_id = $orderID;
        $model->takeout_id = $data['id'];
        $model->name = $data['title'];
        $model->price = $data['price'];
        $model->deposit = $data['deposit'];
        $model->num = $data['num'];

        $takeout = TakeoutBls::find($data['id']);
        $takeout->stock -= $data['num'];
        $takeout->save();

        return $model->save();
    }

}
