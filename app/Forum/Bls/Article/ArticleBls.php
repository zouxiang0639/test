<?php

namespace App\Forum\Bls\Article;

use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\Model\ArticleModel;
use App\Forum\Bls\Article\Model\ArticlesRecommendModel;
use App\Forum\Bls\Article\Model\ArticlesStarModel;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Forum\Bls\Article\Traits\ThumbsTraits;
use App\Forum\Bls\Users\UsersBls;
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

        //标签
        if(!empty($request->tag)) {
            $model->where('tags', $request->tag);
        }

        //排序
        if(!empty($request->order) && $request->order == 'hot') {
            $order = '`browse` DESC';
            $model->where(function($query) {
                return $query->where('browse','>=', config('config.browse'))->orWhere('recommend_count','>=', config('config.recommend'));
            });
        }

        //热门条件
        if(!empty($request->type) && $request->type == 'hot') {
            $order = '`browse` DESC';
            $model->where(function($query) {
                return $query->where('browse','>=', config('config.browse'))->orWhere('recommend_count','>=', config('config.recommend'));
            });
        }

        //发布人
        if(!empty($request->issuer)) {
            $model->where('issuer', $request->issuer);
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
        return ArticleModel::query()->getQuery()->getConnection()->transaction(function () use($request) {

            $user = Auth::guard('forum')->user();

            //文章发表策略
            static::articleStrategy($user);

            $model = new ArticleModel();
            $model->title = $request->title;
            $model->source = $request->source ?: '';
            $model->tags = $request->tags;
            $model->status = WhetherConst::NO;
            $model->is_hide = $model->tags == 4 ? ($request->is_hide ? WhetherConst::YES : WhetherConst::NO) : WhetherConst::NO;
            $model->contents = $request->contents;
            $model->issuer = $user->id;
            $model->ip =  $request->getClientIp();
            $model->thumbs_up =  [];
            $model->thumbs_down =  [];
            $model->star =  [];
            $model->recommend =  [];

            if($model->save()) {
                return $model;
            }
            return false;
        });
    }

    public static function editArticle(ArticleCreateRequest $request, ArticleModel $model)
    {
        $model->title = $request->title;
        $model->source = $request->source ?: '';
        $model->tags = $request->tags;
        $model->status = WhetherConst::NO;
        $model->is_hide = $model->tags == 4 ? ($request->is_hide ? WhetherConst::YES : WhetherConst::NO) : WhetherConst::NO;
        $model->contents = $request->contents;
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

    public static function findByWithTrashed($id)
    {
        return ArticleModel::withTrashed()->find($id);
    }



    /**
     * 弱
     * @param ArticleModel $model
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsUp(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_up)) {
//            $model->thumbs_up = static::thumbsMinus($model->thumbs_up, $user->id);
//            $user->thumbs_up --;
//            $data = false;
            throw new LogicException(1010002, '只能点一次哦!');
        } else {

            if(static::checkThumbs($model->thumbs_down, $model->thumbs_up, $user->id)) {
                throw new LogicException(1010002, '只能选一个赞或者弱');
            }
            $model->thumbs_up = static::thumbsPlus($model->thumbs_up, $user->id);
            $user->thumbs_up ++;
            $model->recommend_count ++;
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
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsDown(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_down)) {
//            $model->thumbs_down = static::thumbsMinus($model->thumbs_down, $user->id);
//            $data = false;
            throw new LogicException(1010002, '只能点一次哦!');
        } else {

            if(static::checkThumbs($model->thumbs_down, $model->thumbs_up, $user->id)) {
                throw new LogicException(1010002, '只能选一个赞或者弱');
            }

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
     * @throws LogicException
     */
    public static function recommendArticle(ArticleModel $model)
    {
        $userId = Auth::guard('forum')->id();
        if(in_array($userId, $model->recommend)) {
//            ArticlesRecommendModel::where('user_id', $userId)->where('articles_id', $model->id)->delete();
//            $model->recommend = static::thumbsMinus($model->recommend, $userId);
//            $data = false;

            throw new LogicException(1010002,'你已推荐');
        } else {
            $star = new ArticlesRecommendModel();
            $star->user_id = $userId;
            $star->articles_id = $model->id;
            $star->save();
            $model->recommend = static::thumbsPlus($model->recommend, $userId);
            $model->recommend_count ++;
            $data = true;
        }

        if($model->save()) {
            //推荐一个网站加一分
            UsersBls::addIntegral(1);
            return ['data' => $data];
        }
        return false;
    }

    /**
     * 统计用户发了多少文章
     * @param $issuer
     * @return mixed
     */
    public static function ArticleCount($issuer)
    {
        return ArticleModel::where('issuer', $issuer)->count();
    }

    /**
     * 文章发表策略
     * @param $user
     * @throws LogicException
     */
    public static function articleStrategy($user)
    {
        $lastLoginTime = mb_substr($user->last_login_time, 0, 10);
        $day = date('Y-m-d');
        $dayArticle = config('config.day_article');

        if($lastLoginTime == $day && $user->day_article == $dayArticle) {
            //如果当天已发布限制时间抛出错误
            throw new LogicException(1010002, [["每天限制发表{$dayArticle}篇文章"]]);
        } else if($lastLoginTime != $day){
            //如果不是当日发布
            $user->last_login_time = date('Y-m-d H:i:s');
            $user->day_article = 1;
        } else {
            $user->day_article ++;
        }

        $user->save();
    }

    public static function getArticleByIssuer($issuer, $id)
    {
        return ArticleModel::where('issuer', $issuer)->where('id', $id)->first();
    }


}

