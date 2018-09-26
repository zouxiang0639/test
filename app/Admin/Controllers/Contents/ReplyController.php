<?php

namespace App\Admin\Controllers\Contents;

use App\Consts\Admin\Tags\TagsTypeConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Forum\Widgets\Tags;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Admin;
use View;
use Forum;
use Auth;

class ReplyController  extends Controller
{

    public function index(Request $request)
    {

        $list = ReplyBls::getReplyListByAdmin($request);


        $list->getCollection()->each(function($item) {
            $item->issuerName = '-';
            $item->pictureFormat = $item->picture ? explode(',', $item->picture) : [];
            if($issuer = $item->issuers) {
                $item->issuerName = $issuer->name;
            }
        });

        return View::make('admin::contents.reply.index', [
            'list' => $list
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = ReplyBls::find($id);
        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 回复
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function reduction($id)
    {
        $model = ReplyBls::findByWithTrashed($id);
        $this->isEmpty($model);

        if($model->restore()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }


}
