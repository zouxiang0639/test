<?php

namespace App\Bls\Admin\Other\Requests;

use App\Admin\Bls\Other\FeedbackStrategy\FeedbackStrategy;
use App\Library\Validators\JsonResponseValidator;

/**
 * 卡种模版存储验证器
 * @author zouxiang
 */
class FeedbackRequests extends JsonResponseValidator
{


    public function rules()
    {
        $validatorRules = $this->input('type') ? (new FeedbackStrategy($this->input('type')))->validatorRules() : [];
        return array_merge($validatorRules, [
            'content' => 'required',

        ]);
    }

    public function messages()
    {
        $validatorMessages = $this->input('card_kind_tpl_type') ? (new FeedbackStrategy($this->input('card_kind_tpl_type')))->validatorMessages() : [];
        return array_merge($validatorMessages, [
            'content.required' => '内容不能为空',
        ]);
    }


}