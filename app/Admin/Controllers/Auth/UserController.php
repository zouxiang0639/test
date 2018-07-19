<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\Requests\UserRequest;
use App\Admin\Bls\Auth\AdminUserBls;
use App\Admin\Bls\Auth\Model\Permission;
use App\Admin\Bls\Auth\Model\Role;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Redirect;
use Admin;
use View;

class UserController extends Controller
{

    /**
     * 列表
     */
    public function index(Redirect $request)
    {
        $model = AdminUserBls::getAdminUser($request);

        return view('admin::auth.user.index',[
            'list' => $model
        ]);
    }

    /**
     * 修改
     */
    public function edit($id)
    {
        $model = AdminUserBls::find($id);
        return View::make('admin::auth.user.edit',[
          'form' =>  $this->form($model),
          'info' =>  $model
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        if(AdminUserBls::updateAdminUser($request, $id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, ['操作失败']);
        }
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($info)
    {

        return Admin::form(function($item) use ($info)  {
            $form = $item->form;

            $item->create('用户名', function($h) use ($form, $info){
                $h->input = $form->text('username', array_get($info, 'username'), $h->options);
                return $h->set('username', true);
            });

            $item->create('名称', function($h) use ($form, $info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                return $h->set('name', true);
            });

            $item->create('密码', function($h) use ($form, $info){
                $h->input = $form->password('password', $h->options);
                return $h->set('password', true);
            });

            $item->create('确认密码', function($h) use ($form, $info){
                $h->input = $form->password('password_confirmation', $h->options);
                return $h->set('password_confirmation', true);
            });

            $item->create('角色', function($h) use ($form, $info){
                $h->input = $form->multipleSelect('roles[]',  Role::all()->pluck('name', 'id'), array_get($info, 'roles'), $h->options);
                return $h->set('roles', true);
            });

            $item->create('权限', function($h) use ($form, $info){
                $h->input = $form->multipleSelect('permissions[]', Permission::all()->pluck('name', 'id'), array_get($info, 'permissions'), $h->options);
                return $h->set('permissions', true);
            });

        })->getFormHtml();
    }
}
