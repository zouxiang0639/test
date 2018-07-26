<?php

namespace App\Admin\Bls\System\Requests;

use App\Library\Validators\JsonResponseValidator;

class TagsRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'tag_name' => 'required',
            'status' => 'required',
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
            'type.required' => '标签类型不能为空',
            'tag_name.required' => '标签名称不能为空',
            'status.required' => '标签状态不能为空',
        ];
    }


}
