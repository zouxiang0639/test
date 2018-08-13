<?php

namespace App\Admin\Bls\Other\FeedbackStrategy;

use App\Admin\Bls\Other\FeedbackStrategy\Ifc\FeedbackInterface;
use App\Admin\Bls\Other\FeedbackStrategy\Strategy\Feedback;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Bls\Admin\Other\Requests\FeedbackRequests;
use App\Consts\Admin\Other\FeedbackTypeConst;
use App\Exceptions\LogicException;

/**
 * 反馈策略
 * @author zouxiang
 * Date 2018年6月7日
 */
class FeedbackStrategy implements FeedbackInterface
{
    private $_strategy;


    /**
     * 构造函数
     * CardKindTplStrategy constructor.
     * @param integer $type 反馈类型
     */
    public function __construct($type)
    {

        switch ($type) {
            case FeedbackTypeConst::FEEDBACK :  //反馈
                $this->_strategy = new Feedback();
                break;

            default:
                throwException(new LogicException('没有这个反馈类型！'));
                break;
        }
    }

    public function show(FeedbackModel $model)
    {
        return $this->_strategy->show($model);
    }


    public function store(FeedbackRequests $request)
    {
        return $this->_strategy->store($request);
    }

    public function validatorRules()
    {
        return $this->_strategy->validatorRules();
    }

    public function validatorMessages()
    {
        return $this->_strategy->validatorMessages();
    }
}