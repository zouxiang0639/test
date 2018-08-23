<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class OrderPaymentRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'order_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => '订单ID不能为空',
            'order_id.numeric' => '订单ID只能为数字',
        ];
    }


}