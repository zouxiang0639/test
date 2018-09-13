<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ArticleController extends Controller
{
    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tags = Forum::Tags()->getTags($request->tag);

        $this->isEmpty($tags);
        $list = ArticleBls::getArticleLise($request);
        $this->formatData($list->getCollection());

        return view('forum::article.index', [
            'list' => $list,
            'tags' => $tags
        ]);
    }

    public function gather(Request $request)
    {
        $list = ArticleBls::getArticleLise($request);
        $this->formatData($list->getCollection());

        return view('forum::article.gather', [
            'list' => $list,
        ]);
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('forum::article.create');
    }

    /**
     * 处理创建数据
     * @param ArticleCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function createPut(ArticleCreateRequest $request)
    {

        // 敏感词替换为***为例
        $request->contents = Forum::sensitive($request->contents);
        $request->title = Forum::sensitive($request->title);

        if ($model = ArticleBls::createArticle($request)) {
            return (new JsonResponse())->success(route('f.article.info', ['id' => $model->id]));
        } else {
            throw new LogicException(1010002, '发布失败');
        }
    }

    public function edit($id)
    {
        $model = ArticleBls::getArticleByIssuer(Auth::guard('forum')->id(), $id);
        $this->isEmpty($model);
        return view('forum::article.edit', [
            'info' => $model
        ]);
    }

    public function editPut($id, ArticleCreateRequest $request) {
        $model = ArticleBls::getArticleByIssuer(Auth::guard('forum')->id(), $id);

        $this->isEmpty($model);
        if (ArticleBls::editArticle($request, $model)) {
            return (new JsonResponse())->success(route('f.article.info', ['id' => $model->id]));
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     *  详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws LogicException
     */
    public function info($id)
    {
        $model = ArticleBls::findByWithTrashed($id);

        $this->isEmpty($model);
        $this->isEmpty($model->issuers);
        $model->browse ++;
        $model->save();

        $userId = Auth::guard('forum')->id();

        return view('forum::article.info', [
            'info' => $model,
            'userId' => $userId,
            'replyCount' => ReplyBls::countReply($id),
            'checkAuth' => $model->issuer == $userId,
        ]);
    }


    /**
     * 赞
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function thumbsUp($id)
    {
        $model = ArticleBls::find($id);

        $this->isEmpty($model);

        if($data = ArticleBls::thumbsUp($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    /**
     * 弱
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function thumbsDown($id)
    {

        $model = ArticleBls::find($id);

        $this->isEmpty($model);

        if($data = ArticleBls::thumbsDown($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     * @throws \Exception
     * @throws \Throwable
     */
    public function all(Request $request)
    {
        $list = ArticleBls::getArticleLise($request,$order = '`id` DESC', $limit = 1);
        $list->getCollection()->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
        $html = view('forum::article.all', ['list' => $list])->render();

        if($html) {
            return (new JsonResponse())->success($html);
        } else {
            throw new LogicException(1010001);
        }
    }

    /**
     * 收藏
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function star($id)
    {
        $model = ArticleBls::find($id);
        $this->isEmpty($model);

        if($data = ArticleBls::starArticle($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    /**
     * 推荐
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function recommend($id)
    {
        $model = ArticleBls::find($id);
        $this->isEmpty($model);

        if($data = ArticleBls::recommendArticle($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

    public function delete($id)
    {
        $model = ArticleBls::getArticleByIssuer(Auth::guard('forum')->id(), $id);
        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('删除成功');
        } else {
            throw new LogicException(1010002);
        }
    }


    protected function formatData(Collection $item)
    {
        $item->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
    }

    public function search(Request $request)
    {
        $request->merge(['title' => $request->key]);
        $list = ArticleBls::getArticleLise($request);
        $this->formatData($list->getCollection());

        return view('forum::article.search', [
            'list' => $list,
        ]);
    }

}
