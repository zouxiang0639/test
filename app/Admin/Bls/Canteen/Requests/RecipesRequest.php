<?php

namespace App\Admin\Bls\Canteen\Requests;

use App\Library\Validators\JsonResponseValidator;

class RecipesRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'morning' => 'required',
            'lunch' => 'required',
            'dinner' => 'required',
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
            'date.required' => '就餐时间不能为空',
            'morning.required' => '早餐不能为空',
            'lunch.required' => '午餐不能为空',
            'dinner.required' => '晚餐不能为空',
        ];
    }


}
