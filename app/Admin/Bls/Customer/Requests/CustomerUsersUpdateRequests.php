<?php

namespace App\Admin\Bls\Customer\Requests;

use App\Consts\Admin\Customer\RechargeTypeConst;
use App\Library\Validators\JsonResponseValidator;


class CustomerUsersUpdateRequests extends JsonResponseValidator
{

    public function rules()
    {
        return [
            'division' => 'required|numeric',
            'mobile' => 'required|unique:users,mobile',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'division.required' => '分组不能为空',
            'division.numeric' => '分组只能为数字',
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '手机号已被注册',
            'name.required' => '名字不能为空',
        ];
    }


}