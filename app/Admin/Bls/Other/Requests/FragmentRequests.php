<?php

namespace App\Admin\Bls\Other\Requests;

use App\Admin\Bls\Other\FeedbackStrategy\FeedbackStrategy;
use App\Library\Validators\JsonResponseRequests;


class FragmentRequests extends JsonResponseRequests
{


    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
        ];
    }


}