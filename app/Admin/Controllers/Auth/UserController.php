<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\Requests\UserRequest;
use App\Admin\Bls\Auth\AdminUserBls;
use App\Admin\Bls\Auth\Model\Permission;
use App\Admin\Bls\Auth\Model\Role;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Response\JsonResponse;
use Redirect;
use Admin;
use View;

class UserController extends Controller
{


    /**
     * 管理员列表
     * @param Redirect $request
     * @return View
     */
    public function index(Redirect $request)
    {
        $model = AdminUserBls::getAdminUser($request);

        return view('admin::auth.user.index', [
            'list' => $model
        ]);
    }

    /**
     * 管理员创建
     * @return View
     */
    public function create()
    {
        return view('admin::auth.user.create', [
            'form' => $this->form([]),
        ]);
    }

    /**
     * 管理员存储
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(UserRequest $request)
    {
        if(AdminUserBls::storeAdminUser($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 管理员编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = AdminUserBls::find($id);
        return View::make('admin::auth.user.edit', [
          'form' =>  $this->form($model),
          'info' =>  $model
        ]);
    }

    /**
     * 管理员更新
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(UserRequest $request, $id)
    {
        if(AdminUserBls::updateAdminUser($request, $id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
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

            $item->create('用户名', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('username', array_get($info, 'username'), $h->options);
                $h->set('username', true);
            });

            $item->create('名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                $h->set('name', true);
            });

            $item->create('密码', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->password('password', $h->options);
                $h->set('password', true);
            });

            $item->create('确认密码', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->password('password_confirmation', $h->options);
                $h->set('password_confirmation', true);
            });

            $item->create('角色', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->multipleSelect('roles[]',  Role::all()->pluck('name', 'id'), array_get($info, 'roles'), $h->options);
                $h->set('roles', true);
            });

            $item->create('权限', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->multipleSelect('permissions[]', Permission::all()->pluck('name', 'id'), array_get($info, 'permissions'), $h->options);
                $h->set('permissions', true);
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
