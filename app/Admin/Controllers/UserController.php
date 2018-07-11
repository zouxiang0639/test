<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\Requests\UserRequest;
use App\Admin\Controllers\Validator\UserValidator;
use App\Bls\Auth\AdminUserBls;
use App\Bls\Auth\Model\Permission;
use App\Bls\Auth\Model\Role;
use App\Http\Controllers\Controller;
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

        $model->getCollection()->each(function($item) {

            $item->rolesName = '-';

            if($roles =$item->roles) {
                $item->rolesName = $roles->implode('name', ',');
            }
        });

        return view('admin::user.index',[
            'list' => $model
        ]);
    }

    /**
     * 修改
     */
    public function edit($id)
    {
        $model = AdminUserBls::find($id);
        return View::make('admin::user.edit',[
          'form' =>  $this->form($model)
        ]);
    }

    public function update(UserRequest $request, $id)
    {

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
            $date = $item->date;
            $options = $item->options;

            $date->push(['用户名', 'username', true,
                $form->text('username', array_get($info, 'username'), $options) ]);

            $date->push(['名称', 'name', true,
                $form->text('name', array_get($info, 'name'), $options) ]);

            $date->push(['密码', 'password', false,
                $form->password('password', $options) ]);

            $date->push(['确认密码', 'password_confirmation', false,
                $form->password('password_confirmation', $options) ]);

            $date->push(['角色', 'roles[]', true,
                $form->multipleSelect('roles',  Role::all()->pluck('name', 'id'), array_get($info, 'roles'), $options) ]);

            $date->push(['权限', 'permissions[]', true,
                $form->multipleSelect('permission', Permission::all()->pluck('name', 'id'), array_get($info, 'permission'), $options) ]);

        }, ['url' => route('m.user.update', ['id' =>1])]);
    }
}
