<?php

namespace App\Forum\Bls\Users\Requests;

use App\Library\Forum\Validators\JsonResponseForumValidator;

class RegisterUserRequest extends JsonResponseForumValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|unique:users,name',
            'password' => 'required|confirmed|max:255',
            'is_read' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱格式已被注册',
            'name.required' => ' 昵称不能为空',
            'name.unique' => '用户名已经被使用',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码输入不一致',
            'is_read.required' => '请勾选并阅读空地社区用户注册协议',
        ];
    }


}
