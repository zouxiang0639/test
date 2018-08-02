<?php

namespace App\Forum\Bls\Article;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\Model\ReplyModel;
use App\Forum\Bls\Article\Requests\ReplyCreateRequest;
use App\Forum\Bls\Article\Traits\ThumbsTraits;
use App\Library\Forum\Widgets\Reply;
use Auth;

/**
 * Class ReplyBls.
 */
class ReplyBls
{
    use ThumbsTraits;

    /**
     * 存储回复
     * @param ReplyCreateRequest $request
     * @return bool
     */
    public static function storeReply(ReplyCreateRequest $request)
    {
        $model = new ReplyModel();
        $model->parent_id = $request->parent_id;
        $model->article_id = $request->article_id;
        $model->at = $request->at;
        $model->issuer = Auth::guard('forum')->id();
        $model->contents = $request->contents;
        $model->thumbs_down = [];
        $model->thumbs_up = [];
        return $model->save();
    }

    /**
     * 删除回复
     * @param ReplyModel $model
     * @return bool|null
     * @throws LogicException
     * @throws \Exception
     */
    public static function destroyReply(ReplyModel $model)
    {
        if($model->issuer != Auth::guard('forum')->id()) {
            throw new LogicException(1010001, '参数错误');
        }
        return $model->delete();
    }

    /**
     * 展示回复
     * @param integer $articleId 文章ID
     * @param integer $page 分页
     * @return string
     */
    public static function showReply($articleId, $page)
    {
        $model = ReplyModel::where('article_id', $articleId)->get();
        return (new Reply($model, $articleId))->setTree()->getPage($page)->render();
    }

    /**
     * 展示子集回复
     * @param integer $parentId 父级ID
     * @param integer $articleId 文章ID
     * @return string
     */
    public static function showChildReply($parentId, $articleId)
    {
        $model = ReplyModel::where('parent_id', $parentId)->get();

        return (new Reply($model, $articleId))->setDate()->setView('forum::reply.show_child')->render(['parentId' => $parentId]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return ReplyModel::find($id);
    }

    /**
     * 赞
     * @param ReplyModel $model
     * @return array|bool
     */
    public static function thumbsUp(ReplyModel $model)
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
     * 弱
     * @param ReplyModel $model
     * @return array|bool
     */
    public static function thumbsDown(ReplyModel $model)
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

    public static function countReply($articleId)
    {
        return ReplyModel::where('article_id', $articleId)->count();
    }
}

