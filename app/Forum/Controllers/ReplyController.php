<?php

namespace App\Forum\Controllers;

use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Article\Requests\ReplyCreateRequest;
use App\Forum\Bls\Article\Traits\ArticleColorTraits;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Forum;
use Illuminate\Support\Collection;
use Auth;

class ReplyController extends Controller
{
    use ArticleColorTraits;

    /**
     * 文章发布人
     * @var
     */
    protected $articlesIssuer;

    public function store(ReplyCreateRequest $request)
    {
        $user = Auth::guard('forum')->user();

        //判断是否被禁言
        if($user->excuse_time >= date('Y-m-d')) {
            throw new LogicException(1010002, [['你被禁言到' . $user->excuse_time]]);
        }

        // 敏感词替换为***为例
        $request->contents = Forum::sensitive($request->contents);
        if (ReplyBls::storeReply($request)) {
            return (new JsonResponse())->success('回复成功');
        } else {
            throw new LogicException(1010002, '回复失败');
        }

    }

    public function show($article_id, Request $request)
    {
        //$html = ReplyBls::showReply($article_id, $request->page);
        $request->merge([
            'article_id' => $article_id,
            'parent_id' => 0
        ]);
        $model = ArticleBls::findByWithTrashed($article_id);
        $this->isEmpty($model);
        $this->articlesIssuer = $model->issuer;

        $html = ReplyBls::getReplyList($request, '`id` ASC', 50);
        $this->formatDate($html->getCollection(), $model);

        $html =  view('forum::reply.show_page', [
            'list' => $html,
        ])->render();

        if($html){
            return (new JsonResponse())->success($html);
        } else {
            throw new LogicException(1010001, '没有数据了');
        }

    }

    public function showChild(Request $request)
    {
        $model = ArticleBls::findByWithTrashed($request->article_id);
        $this->isEmpty($model);
        $this->articlesIssuer = $model->issuer;

        //$html = ReplyBls::showChildReply($request->parent_id, $request->article_id);
        $model = ReplyBls::getReplyList($request, '`id` ASC', 1000);
        $this->formatDate($model->getCollection(), $model);

        $html =  view('forum::reply.show_child', [
            'list' => $model,
            'parentId' => $request->parent_id,
        ])->render();
        if($html){
            return (new JsonResponse())->success($html);
        } else {
            throw new LogicException(1010001, '没有数据了');
        }

    }

    public function destroy($id)
    {
        $model = ReplyBls::find($id);

        $this->isEmpty($model);
        if( ReplyBls::destroyReply($model)){
            return (new JsonResponse())->success('删除成功');
        } else {
            throw new LogicException(1010002, '删除成功');
        }

    }

    public function thumbsUp($id)
    {
        $model = ReplyBls::find($id);

        $this->isEmpty($model);

        if($model->issuer == Auth::guard('forum')->id()) {
            throw new LogicException(1010002, '自己的回复不能点');
        }

        if($data = ReplyBls::thumbsUp($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    public function thumbsDown($id)
    {

        $model = ReplyBls::find($id);

        $this->isEmpty($model);


        if($model->issuer == Auth::guard('forum')->id()) {
            throw new LogicException(1010002, '自己的回复不能点');
        }

        if($data = ReplyBls::thumbsDown($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    public function formatDate(Collection $items, $model)
    {
        $userId = \Auth::guard('forum')->id();
        $items->each(function($item) use ($userId, $model) {

            $item->issuerName = '-';  //发布人
            $item->thumbsUpCount = count($item->thumbs_up); //赞数量
            $item->thumbsUpCheck = in_array($userId, $item->thumbs_up); //是否赞过
            $item->thumbsDownCount = count($item->thumbs_down); //弱数量
            $item->thumbsDownCheck = in_array($userId, $item->thumbs_down); //是否弱过
            $item->isDelete = $userId == $item->issuer; //是否有删除的权限
            $item->formatPicture = explode(',', $item->picture); //图片
            $item->atName = ''; //@的用户名称
            $item->color = $this->getColor($item); //更近需求判断颜色
            $item->childrenCount = $item->child()->count(); //是否有子数据

            if($item->parent_id == 0 && $item->childrenCount > 0) {
                $this->formatDate($item->child, $model);
            }

            //信息删除
            if(!is_null($item->deleted_at)) {
                $item->contents = '该回复已被删除';
                $item->formatPicture = [];
                $item->isDelete = false;
            }

            if($model->tags = 4 && $model->issuer == $item->issuer && $model->is_hide == WhetherConst::YES) {
                $item->issuerName = '';
            } else if($issuer = $item->issuers) {
                $item->issuerName = $issuer->name;
            }

            if(!empty($item->at) && $at = $item->ats) {
                $item->atName = $at->name;
            }
        });

    }

}
