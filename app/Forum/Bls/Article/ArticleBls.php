<?php

namespace App\Forum\Bls\Article;

use App\Consts\Common\WhetherConst;
use App\Forum\Bls\Article\Model\ArticleModel;
use App\Forum\Bls\Article\Model\ArticlesRecommendModel;
use App\Forum\Bls\Article\Model\ArticlesStarModel;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Forum\Bls\Article\Traits\ThumbsTraits;
use Auth;

/**
 * Class RoleBls.
 */
class ArticleBls
{

    use ThumbsTraits;

    /**
     * 文章列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getArticleLise($request, $order = '`id` DESC', $limit = 20)
    {
        $model = ArticleModel::query();

        if(!empty($request->tag)) {
            $model->where('tags', $request->tag);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 创建文章
     * @param ArticleCreateRequest $request
     * @return bool
     */
    public static function createArticle(ArticleCreateRequest $request)
    {

        $model = new ArticleModel();
        $model->title = $request->title;
        $model->source = $request->source ?: '';
        $model->tags = $request->tags;
        $model->status = WhetherConst::NO;
        $model->is_hide = $request->is_hide ? WhetherConst::YES : WhetherConst::NO;
        $model->contents = $request->contents;
        $model->issuer = Auth::guard('forum')->id();
        $model->ip =  $request->getClientIp();
        $model->thumbs_up =  [];
        $model->thumbs_down =  [];
        $model->star =  [];
        $model->recommend =  [];

        return $model->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return ArticleModel::find($id);
    }

    /**
     * 弱
     * @param ArticleModel $model
     * @return array|bool
     */
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

    /**
     * 赞
     * @param ArticleModel $model
     * @return array|bool
     */
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

    /**
     * 收藏文章
     * @param ArticleModel $model
     * @return array|bool
     */
    public static function starArticle(ArticleModel $model)
    {
        $userId = Auth::guard('forum')->id();
        if(in_array($userId, $model->star)) {
            ArticlesStarModel::where('user_id', $userId)->where('articles_id', $model->id)->delete();
            $model->star = static::thumbsMinus($model->star, $userId);
            $data = false;
        } else {
            $star = new ArticlesStarModel();
            $star->user_id = $userId;
            $star->articles_id = $model->id;
            $star->save();
            $model->star = static::thumbsPlus($model->star, $userId);
            $data = true;
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;
    }

    /**
     * 推荐文章
     * @param ArticleModel $model
     * @return array|bool
     */
    public static function recommendArticle(ArticleModel $model)
    {
        $userId = Auth::guard('forum')->id();
        if(in_array($userId, $model->recommend)) {
            ArticlesRecommendModel::where('user_id', $userId)->where('articles_id', $model->id)->delete();
            $model->recommend = static::thumbsMinus($model->recommend, $userId);
            $data = false;
        } else {
            $star = new ArticlesRecommendModel();
            $star->user_id = $userId;
            $star->articles_id = $model->id;
            $star->save();
            $model->recommend = static::thumbsPlus($model->recommend, $userId);
            $data = true;
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;
    }


}

