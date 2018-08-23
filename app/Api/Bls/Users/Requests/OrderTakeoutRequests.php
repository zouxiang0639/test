<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class OrderTakeoutRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'mobile' => 'required|mobile',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
        ];
    }


}