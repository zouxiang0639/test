<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class SitePaymentRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'mobile' => 'required|mobile',
            'amount' => 'required|numeric',
            'num' => 'required|numeric',
            'type' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'amount.required' => '总金额不能为空',
            'amount.numeric' => '总金额只能为数字',
            'num.required' => '数量不能为空',
            'num.numeric' => '数量只能为数字',
            'type.required' => '类型不能为空',
            'type.numeric' => '类型只能为数字',
        ];
    }


}