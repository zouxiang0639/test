<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\Requests\UserRequest;
use App\Admin\Bls\Auth\AdminUserBls;
use App\Admin\Bls\Auth\Model\Permission;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Redirect;
use Admin;
use View;

class PermissionsController extends Controller
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

    public function create()
    {
        return view('admin::auth.permissions.create',[
            'form' =>  $this->form([]),
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
            $item->create('标识', function($h) use ($form, $info){
                $h->input = $form->text('username', array_get($info, 'username'), $h->options);
                return $h->set('username', true);
            });

            $item->create('名称', function($h) use ($form, $info){
                $h->input = $form->text('username', array_get($info, 'username'), $h->options);
                $h->set('username', true);
            });

            $item->create('HTTP方法', function($h) use ($form, $info){
                $array = Permission::all()->pluck('name', 'id');
                $h->input = $form->multipleSelect('permissions[]', $array, array_get($info, 'permissions'), $h->options);
                return $h->set('username', true);
            });

            $item->create('HTTP路径', function($h) use ($form, $info){
                $h->input = $form->text('username', array_get($info, 'username'), $h->options);
                $h->set('username', true);
            });
        })->getFormHtml();
    }
}
