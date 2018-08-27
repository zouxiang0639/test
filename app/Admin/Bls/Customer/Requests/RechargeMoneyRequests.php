<?php

namespace App\Admin\Bls\Customer\Requests;

use App\Consts\Admin\Customer\RechargeTypeConst;
use App\Library\Validators\JsonResponseValidator;


class RechargeMoneyRequests extends JsonResponseValidator
{

    public function rules()
    {
        return [
            'money' => 'money:1',
            'type' => 'required',
            'division' => 'required_if:type,' . RechargeTypeConst::GROUP,
            'user' => 'required_if:type,' . RechargeTypeConst::ONE,
        ];
    }

    public function messages()
    {
        return [
            'money.money' => '请设置充值金额',
            'type.required' => '类型不能为空',
            'division.required_if' => '分组不能为空',
            'user.required_if' => '用户不能为空',
        ];
    }


}