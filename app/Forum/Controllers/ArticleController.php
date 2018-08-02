<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $list = ArticleBls::getArticleLise($request);
        return view('forum::article.index', [
            'list' => $list
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
         if (ArticleBls::createArticle($request)) {
             return (new JsonResponse())->success('发布成功');
         } else {
             throw new LogicException(1010002, '发布失败');
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
        $model = ArticleBls::find($id);

        $this->isEmpty($model);
        $this->isEmpty($model->issuers);
        $model->browse ++;
        $model->save();

        return view('forum::article.info', [
            'info' => $model,
            'userId' => Auth::guard('forum')->id(),
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

    public function all(Request $request)
    {
        $list = ArticleBls::getArticleLise($request,$order = '`id` DESC', $limit = 1);
        $html = view('forum::article.all', ['list' => $list])->render();

        if($html) {
            return (new JsonResponse())->success($html);
        } else {
            throw new LogicException(1010001);
        }
    }


}
