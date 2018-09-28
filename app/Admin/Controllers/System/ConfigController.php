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
use Storage;

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

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function set()
    {
        $form = Admin::form(function(Forms $item) {

            $item->create('网站标题', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->text('title', config('config.title'), $h->options);
                $h->set('title', false);
                $h->helpBlock = '（网站显示标题）';
            });

            $item->create('网站描述', function(HtmlFormTpl $h, FormBuilder $form){
                $h->input = $form->textarea('description', config('config.description'), $h->options);
                $h->set('description', false);
                $h->helpBlock = '（网站搜索引擎描述）';
            });

            $item->create('网站关键字', function(HtmlFormTpl $h, FormBuilder $form){
                $h->input = $form->textarea('keywords', config('config.keywords'), $h->options);
                $h->set('keywords', false);
                $h->helpBlock = '（网站搜索引擎关键字） 多个用 ( , )隔开';
            });

            $item->create('网站备案号', function(HtmlFormTpl $h, FormBuilder $form){
                $h->input = $form->text('icp', config('config.icp'), $h->options);
                $h->set('icp', false);
                $h->helpBlock = '（设置在网站底部显示的备案号，如“沪ICP备12007941号-2）';
            });

            $item->create('默认图片', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->imageOne('default_picture', config('config.default_picture'), $h->options);
                $h->set('default_picture', false);
                $h->helpBlock = '（图片损坏或者默认显示图片）';
            });

            $item->create('浏览器上ico logo', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->imageOne('ico', config('config.ico'), $h->options);
                $h->set('ico', false);
                $h->helpBlock = '（ 后缀为.ico）';
            });

            $item->create('logo', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->imageOne('logo', config('config.logo'), $h->options);
                $h->set('logo', false);
                $h->helpBlock = '（ 网址logo）';
            });


        })->getFormHtml();
        $forum = Admin::form(function(Forms $item) {

            $item->create('浏览量', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->number('browse', config('config.browse'), $h->options);
                $h->set('browse', false);
                $h->helpBlock = '（假如设置1000,文章浏览量到达1000会触发 推荐机制）';
            });

            $item->create('推荐量', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->number('recommend', config('config.recommend'), $h->options);
                $h->set('recommend', false);
                $h->helpBlock = '（假如设置100,文章推荐量到达100会触发 推荐机制）';
            });

            $item->create('当天可发布文章', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->number('day_article', config('config.day_article'), $h->options);
                $h->set('day_article', false);
                $h->helpBlock = '（假如设置10,设置后当天用户只能发10篇文章）';
            });

        })->getFormHtml();

        $words = Storage::disk('local')->get('words.txt');

        return View::make('admin::system.config.set',[
            'form' => $form,
            'forum' => $forum,
            'words' => $words
        ]);
    }

    /**
     * 批量修改配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function setPost(Request $request)
    {

        if((new ConfigBls())->configUpdateByArray($request->all())) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 保存铭感词汇
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function sensitive(Request $request)
    {
        if(Storage::disk('local')->put('words.txt', $request->words)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 设置配置
     *
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
