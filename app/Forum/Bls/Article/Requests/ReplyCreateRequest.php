<?php

namespace App\Forum\Bls\Article\Requests;

use App\Library\Forum\Validators\JsonResponseForumValidator;

class ReplyCreateRequest extends JsonResponseForumValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'at' => 'required',
            'article_id' => 'required',
            'contents' => 'required',
            'parent_id' => 'required',
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
            'contents.required' => '请输入回复内容',
        ];
    }


}
