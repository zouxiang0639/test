<?php

namespace App\Forum\Bls\Users\Requests;

use App\Library\Forum\Validators\JsonResponseForumValidator;
use Session;

class bindPutRequest extends JsonResponseForumValidator
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

        return  [
            'email' => 'required|email',
            'email_verify' => 'required|emailAuth',
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
            'email_verify.required' => '邮箱验证码不能为空',
            'email_verify.email_auth' => '邮箱验证码不正确',

        ];
    }


}
