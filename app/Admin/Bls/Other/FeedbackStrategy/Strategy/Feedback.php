<?php

namespace App\Admin\Bls\Other\FeedbackStrategy\Strategy;

use App\Admin\Bls\Other\FeedbackStrategy\Ifc\FeedbackInterface;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;

/**
 * @author zouxiang
 */
class Feedback implements FeedbackInterface
{
    private $extend = [
        'num' => '评分',
    ];

    public function store(FeedbackRequests $request)
    {
        return [
            'extend' => [
                'num' => $request->num,
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