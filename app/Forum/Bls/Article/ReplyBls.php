<?php

namespace App\Forum\Bls\Article;

use App\Consts\Admin\User\InfoTypeConst;
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

    const SEND_INFO_BY_NUMBER = [5, 10, 20, 50, 100, 200, 500, 1000, 10000]; //按编号发送信息

    //点赞提示内容
    const THUMBS_UP_COLOR = [
        10 => '萌萌新绿', //萌萌新绿
        100 => '森森满绿' //森森满绿
    ];

    //点弱提示内容
    const THUMBS_DOWN_COLOR = [
        10 => '反对浅红' //反对浅红
    ];

    public static function getReplyList($request, $order = '`id` DESC', $limit = 20)
    {
        $model = ReplyModel::query();

        if(!empty($request->article_id)) {
            $model->where('article_id', $request->article_id);
        }

        if(!is_null($request->parent_id)) {
            $model->where('parent_id', $request->parent_id);
        }
        $model->withTrashed();
        return $model->orderByRaw($order)->paginate($limit);
    }


    /**
     * 存储回复
     * @param ReplyCreateRequest $request
     * @return bool
     * @throws LogicException
     */
    public static function storeReply(ReplyCreateRequest $request)
    {
        $model = new ReplyModel();
        $model->parent_id = $request->parent_id;
        $model->article_id = $request->article_id;
        $model->at = $request->at;
        $model->issuer = Auth::guard('forum')->id();
        $model->contents = $request->contents;
        $model->picture = $request->picture ?: '';
        $model->thumbs_down = [];
        $model->thumbs_up = [];
        $article =  $model->article;
        if(empty($article) || !is_null($article->deleted_at)) {
            throw new LogicException(1010002, [['文章已被删除,不能评论']]);
        }

        if($model->save()) {

            if($model->at== 0) { //文章回复
                $article->count_new_reply ++;
                $article->save();

                //信息创建
                $operatorId = Auth::guard('forum')->id();
                $content = '你的帖子';
                $content .= '<a href="'. route('f.article.info', ['id' => $model->id], false) .'"> ‘' . e($article->title) . '’ </a>';
                $content .= '有'. $article->count_new_reply .'个新回复';
                InfoBls::createInfo($article->issuer, $operatorId, InfoTypeConst::ARTICLE_REPLY, $content, $article->id);

            } else if($model->at != 0) { //子回复
                //信息创建
                $operatorId = Auth::guard('forum')->id();
                $content = '你的回复';
                $content .= '<a href="'. route('f.article.info', ['id' => $model->id], false) .'"> ‘' . e(mb_substr($model->parent->contents,0,20)) . '’ </a>';
                $content .= '有个新回复';
                InfoBls::createInfo($article->issuer, $operatorId, InfoTypeConst::AT, $content);

            }

            return $model;
        };

        return false;


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
        $model = ReplyModel::withTrashed()->where('article_id', $articleId)->get();
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
        $model = ReplyModel::withTrashed()->where('parent_id', $parentId)->get();

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
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsUp(ReplyModel $model)
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
            $data = true;
        }

        $model->save();

        //信息创建
        $count = count($model->thumbs_up);
        if(in_array($count, static::SEND_INFO_BY_NUMBER)) {
            $operatorId = Auth::guard('forum')->id();
            $content = '你的回复';
            $content .= '<a href="'. route('f.article.info', ['id' => $model->article_id], false) .'"> ‘' . e(mb_substr($model->contents,0,20)) . '’ </a>';
            $content .= '得了'. $count .'个赞';
            $content .= in_array($count, array_keys(static::THUMBS_UP_COLOR)) ? '变色了['.array_get(static::THUMBS_UP_COLOR, $count).']': '';
            InfoBls::createInfo($model->issuer, $operatorId, InfoTypeConst::THUMBS_UP, $content);
        }

        if($user->save()) {
            return ['data' => $data];
        }
        return false;
    }

    /**
     * 弱
     * @param ReplyModel $model
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsDown(ReplyModel $model)
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
            $user->thumbs_down ++;
            $user->save();

            $model->thumbs_down = static::thumbsPlus($model->thumbs_down, $user->id);
            $data = true;
        }

        //信息创建
        $count = static::countReplyById($model->id);
        if(in_array($count, static::SEND_INFO_BY_NUMBER)) {
            $operatorId = Auth::guard('forum')->id();
            $content = '你的回复';
            $content .= '<a href="'. route('f.article.info', ['id' => $model->article_id], false) .'"> ‘' . e(mb_substr($model->contents,0,20)) . '’ </a>';
            $content .= '得了'. $count .'个赞';
            $content .= in_array($count, array_keys(static::THUMBS_UP_COLOR)) ? '变色了['.array_get(static::THUMBS_DOWN_COLOR, $count).']': '';
            InfoBls::createInfo($model->issuer, $operatorId, InfoTypeConst::THUMBS_UP, $content);
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;
    }

    public static function countReply($articleId)
    {
        return ReplyModel::where('article_id', $articleId)->withTrashed()->count();
    }

    public static function countReplyById($id)
    {
        return ReplyModel::where('id', $id)->withTrashed()->count();
    }

    public static function countReplyParent($articleId, $parentId, $at)
    {
        return ReplyModel::where('article_id', $articleId)->where('at', $at)->where('parent_id', $parentId)->withTrashed()->count();
    }


    /**
     * 根据用户去统计回复
     * @param $issuer
     * @return mixed
     */
    public static function countReplyByUser($issuer)
    {
        return ReplyModel::where('issuer', $issuer)->withTrashed()->count();
    }

    public static function replyJoinArticle($userId, $limit = 10)
    {
        $model = ReplyModel::query();
        $model->leftJoin('articles as a','reply.article_id','=','a.id');
        $model->leftJoin('users as u','a.issuer','=','u.id');
        $model->where('reply.issuer', $userId);
        $model->orderBy('r_id', 'desc');
        $model->select('reply.created_at as r_created_at', 'reply.contents as r_contents', 'reply.thumbs_up as r_thumbs_up',
            'reply.thumbs_down as r_thumbs_down', 'reply.id as r_id', 'u.name as u_name', 'a.browse as a_browse',
            'a.title as a_title', 'a.tags as a_tags','a.recommend as a_recommend', 'a.created_at as a_created_at',
            'a.id as a_id'
        );
        return $model->paginate($limit);
    }
}

