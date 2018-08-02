<?php

namespace App\Forum\Bls\Article;

use App\Consts\Common\WhetherConst;
use App\Forum\Bls\Article\Model\ArticleModel;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Forum\Bls\Article\Traits\ThumbsTraits;
use Auth;

/**
 * Class RoleBls.
 */
class ArticleBls
{

    use ThumbsTraits;

    public static function getArticleLise($request, $order = '`id` DESC', $limit = 20)
    {
        $model = ArticleModel::query();

        if(!empty($request->tag)) {
            $model->where('tags', $request->tag);
        }

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
        $model->thumbs_up =  [];
        $model->thumbs_down =  [];
        return $model->save();
    }

    public static function find($id)
    {
        return ArticleModel::find($id);
    }

    public static function thumbsUp(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_up)) {
            $model->thumbs_up = static::thumbsMinus($model->thumbs_up, $user->id);
            $user->thumbs_up --;
            $data = false;
        } else {
            $model->thumbs_up = static::thumbsPlus($model->thumbs_up, $user->id);
            $user->thumbs_up ++;
            $data = true;
        }
        $model->save();

        if($user->save()) {
            return ['data' => $data];
        }
        return false;
    }

    public static function thumbsDown(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_down)) {
            $model->thumbs_down = static::thumbsMinus($model->thumbs_down, $user->id);
            $data = false;
        } else {
            $model->thumbs_down = static::thumbsPlus($model->thumbs_down, $user->id);
            $data = true;
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;

    }


}

