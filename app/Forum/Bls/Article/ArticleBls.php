<?php

namespace App\Forum\Bls\Article;

use App\Admin\Bls\Auth\Model\ArticleModel;
use App\Consts\Common\WhetherConst;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use Auth;

/**
 * Class RoleBls.
 */
class ArticleBls
{

    public static function getArticleLise($tags, $order = '`id` DESC', $limit = 20)
    {
        $model = ArticleModel::query();
        $model->where('tags', $tags);
        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function createArticle(ArticleCreateRequest $request)
    {
        $model = new ArticleModel();
        $model->title = $request->title;
        $model->source = $request->source;
        $model->tags = $request->tags;
        $model->status = WhetherConst::NO;
        $model->is_hide = $request->is_hide ? WhetherConst::YES : WhetherConst::NO;
        $model->contents = $request->contents;
        $model->issuer = Auth::guard('forum')->id();
        $model->ip =  $request->getClientIp();
        return $model->save();
    }

    public static function find($id)
    {
        return ArticleModel::find($id);
    }
}

