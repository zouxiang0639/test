<?php

namespace App\Api\Bls\Users\Requests;

use App\Library\Admin\Widgets\Security;
use App\Library\Validators\JsonResponseApiRequests;

class UsersRegisterRequests extends JsonResponseApiRequests
{

    public function rules()
    {
        return [
            'tag' => 'required|numeric',
            'mobile' => 'required|unique:users',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tag.required' => '分组不能为空',
            'tag.numeric' => '分组只能为数字',
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '手机号已被注册',
            'name.required' => '名字不能为空',
        ];
    }


}