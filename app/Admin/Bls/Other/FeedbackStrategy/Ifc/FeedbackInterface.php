<?php

namespace App\Admin\Bls\Other\FeedbackStrategy\Ifc;

use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;

interface FeedbackInterface
{
    /**
     * 反馈存储
     * @param FeedbackRequests $request
     * @return array
     */
    public function store(FeedbackRequests $request);

    /**
     * 展示
     * @param FeedbackModel $model
     * @return mixed
     */
    public function show(FeedbackModel $model);

    /**
     * 反馈存储验证规则
     * @return array
     */
    public function validatorRules();

    /**
     * 反馈存储验证描述
     * @return array
     */
    public function validatorMessages();
}