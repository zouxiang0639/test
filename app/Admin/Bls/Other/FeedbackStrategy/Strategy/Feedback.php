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
        'title' => '标题',
    ];

    public function store(FeedbackRequests $request)
    {
        return [
            'extend' => [
                'title' => $request->title,
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
            'title' => 'required',
        ];
    }

    public function validatorMessages()
    {
        return [
            'title.required' => '标题不能为空',
        ];
    }
}