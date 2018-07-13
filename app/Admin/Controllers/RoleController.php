<?php

namespace App\Admin\Controllers;

use App\Admin\Bls\Auth\Requests\RoleRequest;
use App\Admin\Bls\Auth\RoleBls;
use App\Admin\Bls\Auth\Model\Permission;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Redirect;
use Admin;
use View;

class RoleController extends Controller
{


    /**
     * 列表
     * @param Redirect $request
     * @return View
     */
    public function index(Redirect $request)
    {
        $model = RoleBls::getRoleList($request);

        return view('admin::role.index',[
            'list' => $model
        ]);
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin::role.create',[
            'form' =>  $this->form()
        ]);
    }

    /**
     * 存储
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(RoleRequest $request)
    {
        if(RoleBls::storeRole($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, ['操作失败']);
        }
    }


    /**
     * 修改
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = RoleBls::find($id);
        return View::make('admin::role.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * 更新
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(RoleRequest $request, $id)
    {
        if(RoleBls::updateRole($request, $id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, ['操作失败']);
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
        if(RoleBls::destroyRole($id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, ['操作失败']);
        }
    }

    /**
     * @param array $info
     * @return mixed
     */
    protected function form($info = [])
    {

        return Admin::form(function($item) use ($info)  {
            $form = $item->form;
            $date = $item->date;
            $options = $item->options;
            $date->push(['标识', 'slug', true,
                $form->text('slug', array_get($info, 'slug'), $options) ]);

            $date->push(['名称', 'name', true,
                $form->text('name', array_get($info, 'name'), $options) ]);

            $date->push(['权限', 'permissions', true,
                $form->dualListBox('permissions[]',  Permission::all()->pluck('name', 'id'), array_get($info, 'permissions'), $options) ]);

            $date->push(['创建时间', 'created_at', false,
                $form->display(array_get($info, 'created_at')) ]);

            $date->push(['更新时间', 'updated_at', false,
                $form->display(array_get($info, 'updated_at')) ]);

        }, []);
    }
}
