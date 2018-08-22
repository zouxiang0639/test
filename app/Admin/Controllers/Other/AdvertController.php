<?php


namespace App\Admin\Controllers\Other;

use App\Admin\Bls\Other\AdvertBls;
use App\Admin\Bls\Other\Requests\AdvertRequests;
use App\Consts\Admin\Other\AdvertTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Admin;
use View;

/**
 * Created by AdvertController.
 * @author: zouxiang
 * @date:
 */
class AdvertController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if($request->type == null) {
            $request->merge(['type' => AdvertTypeConst::BANNER]);
        }
        $list = AdvertBls::getAdvertList($request);

        $list->getCollection()->each(function($item) {
            $item->typeName = AdvertTypeConst::getDesc($item->type);
            $item->picture = uploads_path($item->picture);
        });

        return View::make('admin::other.advert.index',[
            'list' => $list,
            'type' => AdvertTypeConst::desc(true)
        ]);
    }


    /**
     * 创建
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $typeName = AdvertTypeConst::getDesc($request->type);

        $this->isEmpty($typeName);

        $info = [
            'typeName' => $typeName,
            'type' => $request->type
        ];
        return View::make('admin::other.advert.create',[
            'form' =>  $this->form($info),
        ]);
    }

    /**
     * 存储
     * @param AdvertRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(AdvertRequests $request)
    {
        if(AdvertBls::storeAdvert($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }


    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = AdvertBls::find($id);

        $this->isEmpty($model);
        $model->typeName = AdvertTypeConst::getDesc($model->type);

        return View::make('admin::other.advert.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * @param AdvertRequests $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(AdvertRequests $request, $id)
    {
        $model = AdvertBls::find($id);

        $this->isEmpty($model);

        if(AdvertBls::updateAdvert($model, $request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = AdvertBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 更新状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = AdvertBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }

    /**
     * 更新热度
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function hot(Request $request)
    {
        $model = AdvertBls::find($request->pk);
        $model->hot = intval($request->value);
        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }

    /**
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function(Forms $item) use ($info) {

            $item->create('类型', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'typeName')). $form->hidden('type', array_get($info, 'type'));
                $h->set('type', false);
            });

            $item->create('状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('status',  array_get($info, 'status', WhetherConst::YES));
                $h->set('status', true);
            });

            $item->create('标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('图片', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->imageOne('picture', array_get($info, 'picture'), $h->options);
                $h->set('picture', true);
            });

            $item->create('链接', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('links', array_get($info, 'links'), $h->options);
                $h->set('links', false);
            });

            $item->create('热度', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->number('hot', array_get($info, 'hot', 0), $h->options);
                $h->set('hot', false);
            });

            $item->create('描述', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('comment',  array_get($info, 'comment'), $h->options);
                $h->set('comment', false);
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });

            $item->create('更新时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'updated_at'));
            });
        })->getFormHtml();
    }

}
