<?php

namespace App\Admin\Bls\Contents\Requests;

use App\Library\Validators\JsonResponseValidator;

class NoticeRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'contents' => 'required',
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
            'title.required' => '标题不能为空',
            'contents.required' => '内容不能为空',
        ];
    }


}
