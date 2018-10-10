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
        \Validator::extend('emailAuth', function ($attribute, $value, $parameters) {
            return $this->session->get('email_auth') == $value && $this->session->get('email_auth_time') > time() ;
        });

        \Validator::extend('checkEmail', function ($attribute, $value, $parameters) {
            return $this->session->get('email') == $value;
        });


        return [
            'email' => 'required|email|unique:users,email|checkEmail',
            'email_verify' => 'required|emailAuth',
            'name' => 'required|max:20|sensitive|unique:users,name',
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
            'email.check_email' => '邮箱必须和发送验证码的邮箱一致',
            'email_verify.required' => '邮箱验证码不能为空',
            'email_verify.email_auth' => '邮箱验证码不正确或者失效',
            'name.required' => ' 昵称不能为空',
            'name.unique' => '用户名已经被使用',
            'name.max' => '昵称字数超出',
            'name.sensitive' => '昵称不能有敏感词汇',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码输入不一致',
            'is_read.required' => '请勾选并阅读空地社区用户注册协议',
        ];
    }


}
