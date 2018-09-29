<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\Auth\PermissionsBls;
use App\Admin\Bls\Auth\Requests\UserRequest;
use App\Admin\Bls\Auth\AdminUserBls;
use App\Admin\Bls\Auth\RoleBls;
use App\Consts\Admin\User\InfoTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\InfoBls;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Admin;
use View;
use Auth;

class UsersController extends Controller
{

    /**
     * 管理员列表
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {

        $model = UsersBls::getUsersList($request);


        return View::make('admin::customer.users.index', [
            'list' => $model
        ]);
    }

    /**
     * 管理员编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = UsersBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::customer.users.edit', [
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }



    /**
     * 禁言
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function excuse(Request $request, $id)
    {
        $model = UsersBls::find($id);
        $this->isEmpty($model);

        $model->excuse_time = $request->date;
        if($model->save()) {
            if($model->excuse_time < date("Y-m-d")) {
                $content = '管理员释放了你禁言, 好好珍惜你的发言权限';
            } else {
                $content = '违法社区规则, 被禁言' . $model->excuse_time . '号';
            }

            InfoBls::createInfo($model->id,Auth::guard('admin')->id(), InfoTypeConst::SYSTEM, $content);
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }

    }

    public function search(Request $request)
    {
        $model = UsersBls::getUserByName($request->keyword);
        $array = [];
        foreach($model as $item) {
            $array[] = [
                'id' => $item->id,
                'text' => $item->name
            ];
        }

        return (new JsonResponse())->success(['items'=>$array]);
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
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function($item) use ($info) {

            $item->create('昵称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(WhetherConst::getDesc(array_get($info, 'status')));
            });

            $item->create('昵称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'name'));
            });

            $item->create('邮箱', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'email'));
            });

            $item->create('积分', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'integral'));
            });

            $item->create('收到的赞', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'thumbs_up'));
            });

            $item->create('收到弱数', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'thumbs_down'));
            });

            $item->create('禁言时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'excuse_time'));
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });

            $item->create('最好活跃时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'updated_at'));
            });


        })->getFormHtml();
    }



}
