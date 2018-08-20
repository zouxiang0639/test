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
        'text1' => '字段1',
        'text2' => '字段2'
    ];

    public function store(FeedbackRequests $request)
    {
        return [
            'extend' => [
                'text1' => '测试1',
                'text2' => '测试2',
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
            //'channel' => 'required',
        ];
    }

    public function validatorMessages()
    {
        return [
            //'channel.required' => '请选择频道',
        ];
    }
}