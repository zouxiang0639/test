<?php

namespace App\Admin\Bls\Auth\Requests;

use App\Library\Validators\JsonResponseValidator;

class UserRequest extends JsonResponseValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'confirmed|max:255',
            'roles' => 'required',
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
            'password.confirmed' => '两次密码输入不一致',
            'roles.required' => '请选择角色',
        ];
    }


}
