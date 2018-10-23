<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class UsersLoginRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'mobile' => 'required|mobile',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'password.required' => '密码不能为空',
        ];
    }


}