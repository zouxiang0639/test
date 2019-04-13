<?php

namespace App\Canteen\Bls\Users\Requests;

use App\Library\Canteen\Validators\JsonResponseCanteenValidator;
use Validator;

class LoginUserRequest extends JsonResponseCanteenValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return preg_match('/^1[0-9]{10}$/', $value);
        });

        return [
            'mobile' => 'required',
            'password' => 'required|max:255',
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
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'password.required' => '密码不能为空',
        ];
    }


}
