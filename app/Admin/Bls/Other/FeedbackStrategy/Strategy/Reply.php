<?php

namespace App\Admin\Bls\Other\FeedbackStrategy\Strategy;

use App\Admin\Bls\Other\FeedbackStrategy\Ifc\FeedbackInterface;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Consts\Admin\Other\FeedbackReportTypeConst;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;

/**
 * @author zouxiang
 */
class Reply implements FeedbackInterface
{
    private $extend = [
        'title' => '标题',
        'report_type' => '举报内容类型',
        'reply_contents' => '回复内容',
        'reply_url' => '回复列表地址',
        'user_name' => '发表人昵称',
    ];

    public function store(FeedbackRequests $request)
    {

        return [
            'extend' => [
                'title' => $request->title,
                'reply_id' => $request->reply_id,
                'report_type' => $request->report_type,
            ],
        ];
    }

    public function show(FeedbackModel $model)
    {
        $extend =  $model->extend;
        $extend['report_type'] = FeedbackReportTypeConst::getDesc($extend['report_type']);


        $reply =  ReplyBls::findByWithTrashed($extend['reply_id']);
        if($reply) {
            $extend['reply_contents'] = $reply->contents;
            $extend['reply_url'] = "<a target='_blank' href='".route('m.contents.reply.list', ['id' => $reply->id])."'>点击跳转</a>";
            $extend['user_name'] = $reply->issuers->name;
        }

        $array = [];
        foreach($extend as $key => $value) {
            if($key = array_get($this->extend, $key)) {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function validatorRules()
    {
        return [
            'title' => 'required',
            'report_type' => 'required',
        ];
    }

    public function validatorMessages()
    {
        return [
            'title.required' => '标题不能为空',
            'report_type.required' => '请选择举报内容类型',
        ];
    }
}