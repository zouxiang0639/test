<?php

namespace App\Admin\Controllers\System;

use App\Admin\Bls\System\ConfigBls;
use App\Admin\Bls\System\Requests\ConfigRequest;
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
class ConfigController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $list = ConfigBls::getConfigList($request);

        return View::make('admin::system.config.index',[
            'list' => $list
        ]);
    }

    /**
     * 创建
     * @return View
     */
    public function create()
    {
        return View::make('admin::system.config.create',[
            'form' =>  $this->form([]),
        ]);
    }

    /**
     * 存储
     * @param ConfigRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(ConfigRequest $request)
    {
        if(ConfigBls::storeConfig($request)) {
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
        $model = ConfigBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::system.config.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * @param configRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(configRequest $request, $id)
    {
        $model = ConfigBls::find($id);

        $this->isEmpty($model);

        if(ConfigBls::updateConfig($model, $request)) {
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
        $model = ConfigBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    public function set()
    {
        $info = ConfigBls::configPluck();
        $form = Admin::form(function(Forms $item) use ($info)  {

            $item->create('网站标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', false);
                $h->helpBlock = '（网站显示标题）';
            });

            $item->create('网站描述', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('description', array_get($info, 'description'), $h->options);
                $h->set('description', false);
                $h->helpBlock = '（网站搜索引擎描述）';
            });

            $item->create('网站关键字', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('keywords', array_get($info, 'keywords'), $h->options);
                $h->set('keywords', false);
                $h->helpBlock = '（网站搜索引擎关键字） 多个用 ( , )隔开';
            });

            $item->create('网站备案号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('icp', array_get($info, 'icp'), $h->options);
                $h->set('icp', false);
                $h->helpBlock = '（设置在网站底部显示的备案号，如“沪ICP备12007941号-2）';
            });

            $item->create('默认图片', function(HtmlFormTpl $h, FormBuilder $form) use($info) {
                $h->input = $form->imageOne('default_picture', array_get($info, 'default_picture'), $h->options);
                $h->set('default_picture', false);
            });

            $item->create('浏览器上ico logo', function(HtmlFormTpl $h, FormBuilder $form) use($info) {
                $h->input = $form->imageOne('ico', array_get($info, 'ico'), $h->options);
                $h->set('ico', false);
            });


        })->getFormHtml();

        return View::make('admin::system.config.set',[
            'form' => $form
        ]);
    }

    public function setPost(Request $request)
    {
        ConfigBls::configUpdateByArray($request->all());
    }

    /**
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function(Forms $item) use ($info)  {

            $item->create('编号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'id'));
            });

            $item->create('配置名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                $h->set('name', true);
            });

            $item->create('配置值', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('value', array_get($info, 'value'), $h->options);
                $h->set('value', true);
            });

            $item->create('描述', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('description', array_get($info, 'description'), $h->options);
                $h->set('description', true);
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
