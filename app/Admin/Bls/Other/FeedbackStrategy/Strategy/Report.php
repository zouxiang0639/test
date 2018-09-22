<?php

namespace App\Admin\Bls\Other\FeedbackStrategy\Strategy;

use App\Admin\Bls\Other\FeedbackStrategy\Ifc\FeedbackInterface;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Consts\Admin\Other\FeedbackReportTypeConst;
use App\Forum\Bls\Article\ArticleBls;

/**
 * @author zouxiang
 */
class Report implements FeedbackInterface
{
    private $extend = [
        'title' => '标题',
        'report_type' => '举报内容类型',
        'article_title' => '文章标题',
        'article_url' => '文章地址',
    ];

    public function store(FeedbackRequests $request)
    {
        return [
            'extend' => [
                'title' => $request->title,
                'article_id' => $request->article_id,
                'report_type' => $request->report_type,
            ],
        ];
    }

    public function show(FeedbackModel $model)
    {
        $extend =  $model->extend;
        $extend['report_type'] = FeedbackReportTypeConst::getDesc($extend['report_type']);


        $article =  ArticleBls::findByWithTrashed($extend['article_id']);
        if($article) {
            $extend['article_title'] = $article->title;
            $extend['article_url'] = "<a target='_blank' href='".route('f.article.info', ['id' => $article->id])."'>".route('f.article.info', ['id' => $article->id])."</a>";
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