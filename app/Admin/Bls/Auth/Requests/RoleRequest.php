<?php

namespace App\Admin\Bls\Auth\Requests;

use App\Library\Validators\JsonResponseValidator;

class RoleRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = 0;
        return [
            'slug' => 'required|alpha|unique:admin_roles,slug,'.$id,
            'name' => 'required',
            'permissions' => 'required',
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
            'slug.required' => '标识不能为空',
            'slug.alpha' => '标识只能为字母',
            'slug.unique' => '标识只能唯一',
            'name.required' => '名称不能为空',
            'permissions.required' => '请选择权限',
        ];
    }


}
