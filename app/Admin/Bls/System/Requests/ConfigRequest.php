<?php

namespace App\Admin\Bls\System\Requests;

use App\Library\Validators\JsonResponseValidator;

class ConfigRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha_dash|unique:admin_config,name,' . $this->id,
            'value' => 'required',
            'description' => 'required',
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
            'name.required' => '配置名称不能为空',
            'name.alpha_dash' => '配置只能字母、数字、破折号（ - ）以及下划线（ _ ）',
            'name.unique' => '配置只能唯一',
            'value.required' => '配置值不能为空',
            'description.required' => '描述不能为空',
        ];
    }


}
