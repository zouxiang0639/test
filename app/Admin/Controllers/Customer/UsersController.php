<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;
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
 * Created by UsersController.
 * @author: zouxiang
 * @date:
 */
class UsersController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $tagList = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        $model = UsersBls::getUsersList($request);

        $model->getCollection()->each(function($item) use ($tagList) {
            $item->divisionNmae = array_get($tagList, $item->division, '-');
            $item->formatMoney = FormatMoney::fen2yuan($item->money);
        });

        return View::make('admin::customer.users.index',[
            'list' => $model,
            'division' => $tagList
        ]);
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = UsersBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::customer.users.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * 修改外卖状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = UsersBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(Request $request, $id)
    {
        $model = UsersBls::find($id);

        $this->isEmpty($model);

        if(UsersBls::updateUsers($model, $request)) {
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

            $item->create('用户编号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'id'));
            });

            $item->create('姓名', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'name'));
            });

            $item->create('手机号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'mobile'));
            });

            $item->create('余额', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(FormatMoney::fen2yuan(array_get($info, 'money')));
            });

            $item->create('分组', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $list = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
                $h->input = $form->select2('division',$list , array_get($info, 'division'), $h->options);
                $h->set('division', true);
            });

            $item->create('状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('status', array_get($info, 'status'));
                $h->set('status', true);
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });
        })->getFormHtml();
    }

}
