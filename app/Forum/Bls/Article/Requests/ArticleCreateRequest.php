<?php

namespace App\Forum\Bls\Article\Requests;

use App\Library\Forum\Validators\JsonResponseForumValidator;

class ArticleCreateRequest extends JsonResponseForumValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tags' => 'required',
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
            'tags.required' => '请选择板块',
            'title.required' => '标题不能为空',
            'contents.required' => '内容不能为空',
        ];
    }


}
