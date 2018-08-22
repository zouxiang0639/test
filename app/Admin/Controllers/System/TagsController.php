<?php

namespace App\Admin\Controllers\System;

use App\Admin\Bls\System\Requests\TagsRequest;
use App\Admin\Bls\System\TagsBls;
use App\Consts\Admin\Tags\TagsTypeConst;
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
 * Created by ConfigController.
 * @author: zouxiang
 * @date:
 */
class TagsController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if(empty($request->type)) {
            $request->merge(['type' => TagsTypeConst::TAG]);
        }

        $list = TagsBls::getTagsList($request);

        return View::make('admin::system.tags.index',[
            'list' => $list,
            'tagsType' => TagsTypeConst::desc()
        ]);
    }


    /**
     * 创建
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $typeName = TagsTypeConst::getDesc($request->type);

        $this->isEmpty($typeName);

        $info = [
            'typeName' => $typeName,
            'type' => $request->type
        ];
        return View::make('admin::system.tags.create',[
            'form' =>  $this->form($info),
        ]);
    }

    /**
     * 存储
     * @param TagsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(TagsRequest $request)
    {
        if(TagsBls::storeTags($request)) {
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
        $model = TagsBls::find($id);

        $this->isEmpty($model);
        $model->typeName = TagsTypeConst::getDesc($model->type);

        return View::make('admin::system.tags.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * @param TagsRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(TagsRequest $request, $id)
    {
        $model = TagsBls::find($id);

        $this->isEmpty($model);

        if(TagsBls::updateTags($model, $request)) {
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
        $model = TagsBls::find($id);

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

        $model = TagsBls::find($id);

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
        $model = TagsBls::find($request->pk);
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

            $item->create('标签类型', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'typeName')). $form->hidden('type', array_get($info, 'type'));
                $h->set('type', true);
            });

            $item->create('标签名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('tag_name', array_get($info, 'tag_name'), $h->options);
                $h->set('tag_name', true);
            });

            $item->create('标签', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = '<span class="input-group-addon"><i class="'.array_get($info, 'icon').'"></i></span>'.
                    $form->text('icon', array_get($info, 'icon'), $h->options);
                $h->set('icon', true);
            });

            $item->create('热度', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('hot', array_get($info, 'hot'), $h->options);
                $h->set('hot', true);
            });

            $item->create('状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('status',  array_get($info, 'status', 1));
                $h->set('status', true);
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
