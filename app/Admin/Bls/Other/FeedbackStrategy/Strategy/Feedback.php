<?php

namespace App\Admin\Bls\Other\FeedbackStrategy\Strategy;

use App\Admin\Bls\Other\FeedbackStrategy\Ifc\FeedbackInterface;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderTypeConst;

/**
 * @author zouxiang
 */
class Feedback implements FeedbackInterface
{
    private $extend = [
        'num' => '评分',
        'title' => '订单',
    ];

    public function store(FeedbackRequests $request)
    {

        $order = OrderBls::find($request->order_id);
        $title = '';
        if($order->type == OrderTypeConst::MEAL) {
            if($orderMeal = $order->orderMeal) {
                $title = $orderMeal->date.MealTypeConst::getDesc($orderMeal->type);
            }
        } else {
            $title = mb_substr($order->created_at, 0, 10).OrderTypeConst::TAKEOUT_DESC;
        }

        return [
            'extend' => [
                'num' => $request->num,
                'order_id' => $request->order_id,
                'title' => $title,
            ],
        ];
    }

    public function show(FeedbackModel $model)
    {
        $array = [];
        foreach($model->extend as $key => $value) {
            if($key = array_get($this->extend, $key)) {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function validatorRules()
    {
        return [
            'contents' => '',
            'num' => 'required',
            'order_id' => 'required',
        ];
    }

    public function validatorMessages()
    {
        return [
            'num.required' => '评分不能为空',
            'order_id.required' => '订单ID不能为空',
        ];
    }
}