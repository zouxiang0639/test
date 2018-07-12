<?php

namespace App\Admin\Controllers;

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

            $date->push(['角色', 'roles', true,
                $form->multipleSelect('roles[]',  Role::all()->pluck('name', 'id'), array_get($info, 'roles'), $options) ]);

            $date->push(['权限', 'permissions', false,
                $form->multipleSelect('permissions[]', Permission::all()->pluck('name', 'id'), array_get($info, 'permissions'), $options) ]);

        }, []);
    }
}
