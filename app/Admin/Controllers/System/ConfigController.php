<?php

namespace App\Admin\Controllers\System;

use App\Admin\Bls\System\ConfigBls;
use App\Admin\Bls\System\Requests\ConfigRequest;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Format\FormatMoney;
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

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function set()
    {
        $form = Admin::form(function(Forms $item) {

            $item->create('公告', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->textarea('notice',  config('config.notice'), $h->options);
                $h->set('notice', false);
                $h->helpBlock = '（会员中心底部公告模块）';
            });

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
        $mealForm = Admin::form(function(Forms $item) {

            $item->create('早餐费', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('morning_price', FormatMoney::fen2yuan(config('config.morning_price')), $h->options);
                $h->set('morning_price', false);
            });

            $item->create('午餐费', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('lunch_price', FormatMoney::fen2yuan(config('config.lunch_price')), $h->options);
                $h->set('lunch_price', false);
            });

            $item->create('晚餐费', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('dinner_price', FormatMoney::fen2yuan(config('config.dinner_price')), $h->options);
                $h->set('dinner_price', false);
            });

            $item->create('早餐截止时间', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->datetime('morning_time', config('config.morning_time'), $h->options, 'HH:mm');
                $h->set('morning_time', false);
            });

            $item->create('午餐截止时间', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->datetime('lunch_time', config('config.lunch_time'), $h->options, 'HH:mm');
                $h->set('lunch_time', false);
            });

            $item->create('晚餐截止时间', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->datetime('dinner_time', config('config.dinner_time'), $h->options, 'HH:mm');
                $h->set('dinner_time', false);
            });

            $item->create('定金', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('meal_deposit', FormatMoney::fen2yuan(config('config.meal_deposit')), $h->options);
                $h->set('meal_deposit', false);
                $h->helpBlock = '（点餐定金）';
            });

            $item->create('折扣1', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->options['max'] = 100;
                $h->input = $form->number('meal_discount1', config('config.meal_discount1', 0), $h->options);
                $h->set('meal_discount1', false);
                $h->helpBlock = '（0-24小时折扣）';
            });

            $item->create('折扣2', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->options['max'] = 100;
                $h->input = $form->number('meal_discount2', config('config.meal_discount2', 0), $h->options);
                $h->set('meal_discount2', false);
                $h->helpBlock = '（24-48小时折扣）';
            });

        })->getFormHtml();

        $takeoutForm = Admin::form(function(Forms $item) {

            $item->create('外卖截止时间', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->datetime('takeout_deadline', config('config.takeout_deadline'), $h->options, 'YYYY-MM-DD');
                $h->set('takeout_deadline', false);
                $h->helpBlock = '（外卖截止时间到期后将不能购买外卖）';
            });
            $item->create('外卖过期日', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->select('takeout_expire_week',array_combine(range(1,7),range(1,7)) , config('config.takeout_expire_week'), $h->options);
                $h->set('takeout_deadline', false);
                $h->helpBlock = '（每周外卖过期时间周1-7,请不要设置也结束时间否则无效）';
            });

        })->getFormHtml();

        return View::make('admin::system.config.set',[
            'form' => $form,
            'mealForm' => $mealForm,
            'takeoutForm' => $takeoutForm
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
