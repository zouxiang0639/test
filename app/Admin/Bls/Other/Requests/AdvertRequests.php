<?php

namespace App\Admin\Bls\Other\Requests;

use App\Library\Validators\JsonResponseValidator;


class AdvertRequests extends JsonResponseValidator
{

    public function rules()
    {
        return [
            'type' => 'required',
            'title' => 'required',
            'picture' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '类型不能为空',
            'title.required' => '标题不能为空',
            'picture.required' => '图片不能为空',
        ];
    }


}