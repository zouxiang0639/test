<?php

namespace App\Forum\Bls\Article;

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
        dd($model->save());
        return $model->save();
    }

    public static function showReply($article_id, $page)
    {
        $model = ReplyModel::where('article_id', $article_id)->get();
        return (new Reply())->setTree($model)->getItem($page)->render();
    }

    public static function showChildReply($parentId)
    {
        $model = ReplyModel::where('parent_id', $parentId)->get();

        return (new Reply())->setDate($model)->setView('forum::reply.show_child')->render(['parentId' => $parentId]);
    }

    public static function find($id)
    {
        return ReplyModel::find($id);
    }

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
}

