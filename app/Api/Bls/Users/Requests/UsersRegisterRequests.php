<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Validators\JsonResponseApiRequests;

class UsersRegisterRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'card_no' => 'required',
            'mobile' => 'required|mobile|unique:users,mobile',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'card_no.required' => '卡号不能为空',
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'name.required' => '名字不能为空',
        ];
    }


}