<?php

namespace App\Admin\Bls\Other\Requests;

use App\Admin\Bls\Other\FeedbackStrategy\FeedbackStrategy;
use App\Library\Validators\JsonResponseRequests;


class FeedbackRequests extends JsonResponseRequests
{


    public function rules()
    {
        $validatorRules = $this->input('type') ? (new FeedbackStrategy($this->input('type')))->validatorRules() : [];
        return array_merge($validatorRules, [
            'contents' => 'required',

        ]);
    }

    public function messages()
    {
        $validatorMessages = $this->input('type') ? (new FeedbackStrategy($this->input('type')))->validatorMessages() : [];
        return array_merge($validatorMessages, [
            'contents.required' => '内容不能为空',
        ]);
    }


}