<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class OrderMealRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'time' => 'required|date_format:Y-m-d H:i:s',
            'mobile' => 'required',
            'type' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'time.required' => '时间不能为空',
            'time.date_format' => '时间格式不正确 Y-m-d H:i:s',
            'type.required' => '类型不能为空',
            'type.numeric' => '类型只能为数字',
        ];
    }


}