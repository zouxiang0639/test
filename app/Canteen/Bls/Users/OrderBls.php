<?php

namespace App\Canteen\Bls\Users;

use App\Canteen\Bls\Canteen\TakeoutBls;
use App\Canteen\Bls\Users\Model\OrderMealModel;
use App\Canteen\Bls\Users\Model\OrderModel;
use App\Canteen\Bls\Users\Model\OrderTakeoutModel;
use App\Consts\Common\AccountFlowTypeConst;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use Auth;

class OrderBls
{


    public static function getOrderList($request, $limit = 20)
    {
        $model = OrderModel::query();

        if(!empty($request->status)) {
            $status = explode('_', $request->status);
            $model->whereIn('status', $status);
        }

        return $model->where('user_id', Auth::guard('canteen')->id())->orderBy('id','desc')->simplePaginate($limit);
    }

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
            $order->type = OrderTypeConst::TAKEOUT;
            $order->payment = $deposit;
            $order->save();

            foreach($data as $item){
                static::createTakeoutOrderByChild($item, $order->id);
            }

            AccountFlowBls::createAccountFlow($user->id, AccountFlowTypeConst::PAYMENT, $deposit, "订单号:{$order->id}外面定金");

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


    public static function createMealOrder($data, $amount, $deposit)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($data, $amount, $deposit) {
            $user = Auth::guard('canteen')->user();
            $user->money -= $deposit;
            $order = new OrderModel();
            $order->user_id = $user->id;
            $order->amount = $amount;
            $order->deposit = $deposit;
            $order->status = OrderStatusConst::DEPOSIT;
            $order->type = OrderTypeConst::MEAL;
            $order->payment = $deposit;
            $order->save();

            static::createMealOrderByChild($data, $order->id);

            $name = "订单号:{$order->id}订购{$data['date']}" . MealTypeConst::getDesc($data['type']) . '定金';
            AccountFlowBls::createAccountFlow($user->id, AccountFlowTypeConst::PAYMENT, $deposit, $name);

            return $user->save();
        });
    }

    public static function createMealOrderByChild($data, $orderId)
    {
        $model = new OrderMealModel();
        $model->order_id = $orderId;
        $model->recipes_id = $data['recipes_id'];
        $model->type = $data['type'];
        $model->date = $data['date'];
        $model->num = $data['num'];
        $model->price = $data['price'];
        $model->discount = intval($data['discount']);
        return $model->save();
    }

}
