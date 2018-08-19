<?php

namespace App\Canteen\Bls\Users\Requests;

use App\Library\Canteen\Validators\JsonResponseCanteenValidator;
use Validator;

class SetupRequest extends JsonResponseCanteenValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|max:255',
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
            'old_password.required' => '原始密码不能为空',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次输入的密码不一样',
        ];
    }


}
