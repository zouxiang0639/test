<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Article\Requests\ReplyCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function store(ReplyCreateRequest $request)
    {
        if (ReplyBls::storeReply($request)) {
            return (new JsonResponse())->success('回复成功');
        } else {
            throw new LogicException(1010002, '回复失败');
        }

    }

    public function show($article_id, Request $request)
    {
        $html = ReplyBls::showReply($article_id, $request->page);

        if($html){
            return (new JsonResponse())->success($html);
        } else {
            throw new LogicException(1010001, '没有数据了');
        }

    }

    public function showChild(Request $request)
    {

        $html = ReplyBls::showChildReply($request->parent_id);
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

        if($data = ReplyBls::thumbsDown($model)) {
            return (new JsonResponse())->success($data['data']);
        } else {
            throw new LogicException(1010002);
        }
    }

}
