<?php

namespace App\Api\Controllers;

use App\Api\Bls\Users\Requests\OrderMealRequests;
use App\Api\Bls\Users\Requests\OrderPaymentRequests;
use App\Api\Bls\Users\Requests\OrderTakeoutRequests;
use App\Canteen\Bls\Users\OrderBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Order\OrderStatusConst;
use App\Http\Controllers\ApiController;

class OrderController extends ApiController
{
    /**
     * 查询就餐订单
     * @param OrderMealRequests $requests
     * @return \Illuminate\Http\JsonResponse
     */
    public function meal(OrderMealRequests $requests)
    {
        $model = UsersBls::getUsersByMobile($requests->mobile);
        if(is_null($model)) {
            return $this->error(1050004);
        }

        $model = OrderBls::getOrderByMeal($requests->time, $requests->type, $model->id);
        if(is_null($model)) {
            return $this->error(1050003);
        }

        return $this->success($model);

    }

    /**
     * 查询外卖
     * @param OrderTakeoutRequests $requests
     * @return \Illuminate\Http\JsonResponse
     */
    public function takeout(OrderTakeoutRequests $requests)
    {
        $model = UsersBls::getUsersByMobile($requests->mobile);
        if(is_null($model)) {
            return $this->error(1050004);
        }

        $model = OrderBls::getOrderTakeout($model->id);
        if($model->isEmpty()) {
            return $this->error(1050003);
        }
        
        return $this->success($model);
    }

    /**
     * 订单支付
     * @param OrderPaymentRequests $requests
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(OrderPaymentRequests $requests)
    {
        $order = OrderBls::find($requests->order_id);
        if(is_null($order)) {
            return $this->error(1050003);
        }

        //验证订单是否已被支付
        if($order->status != OrderStatusConst::DEPOSIT) {
            return $this->error(1050006);
        }

        $users = $order->users;
        if(is_null($users)) {
            return $this->error(1050004);
        }

        //验证支付令牌是否错误
        if($users->remember_token != $requests->token) {
            return $this->error(1050005);
        }

        //减去用户金额
        $users->money -= $order->amount - $order->payment;
        if($users->money < 0) {
            return $this->error(1050007);
        }

        if(OrderBls::payment($order, $users)) {
            return $this->success(['money' => $users->money, 'mobile' => $users->mobile]);
        } else {
            return $this->error(1010002);
        }
    }
}
