<?php

namespace App\Admin\Bls\Canteen\Requests;

use App\Library\Validators\JsonResponseValidator;

class TakeoutRequest extends JsonResponseValidator
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
            'picture' => 'required',
            'stock' => 'required',
            'deposit' => 'required',
            'status' => 'required|numeric',
            'limit' => 'required|numeric',
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
            'status.required' => '状态不能为空',
            'title.required' => '标题不能为空',
            'picture.required' => '图片不能为空',
            'stock.required' => '库存不能为空',
            'stock.numeric' => '库存必须为数字',
            'price.required' => '价格不能为空',
            'deposit.required' => '定金不能为空',
            'limit.required' => '每个人限购不能为空',
            'limit.numeric' => '每个人限购必须为数字',

        ];
    }


}
