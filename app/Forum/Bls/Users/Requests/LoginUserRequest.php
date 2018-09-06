<?php

namespace App\Forum\Bls\Users\Requests;

use App\Library\Forum\Validators\JsonResponseForumValidator;
use Session;

class LoginUserRequest extends JsonResponseForumValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $array =  [
            'email' => 'required|email',
            'password' => 'required|max:255',
        ];

        if(intval(Session::get('login_num')) > 5) {
            $array['captcha'] = 'required|captcha';
        }

        return $array;
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
            'password.required' => '密码不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码错误'
        ];
    }


}
