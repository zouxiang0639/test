<?php

namespace App\Admin\Bls\Auth\Requests;

use App\Library\Validators\JsonResponseValidator;

class PermissionsRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|unique:admin_permissions,slug,'.$this->id,
            'name' => 'required',
            'http_path' => 'required',
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
            'slug.unique' => '标识只能唯一',
            'name.required' => '名称不能为空',
            'http_path.required' => 'HTTP路径不能为空',
        ];
    }


}
