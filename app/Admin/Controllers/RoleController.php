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
     */
    public function index(Redirect $request)
    {
        $model = RoleBls::getRoleList($request);

        return view('admin::role.index',[
            'list' => $model
        ]);
    }

    public function create()
    {
        return View::make('admin::role.create',[
            'form' =>  $this->form()
        ]);
    }

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
     */
    public function edit($id)
    {

    }

    public function update()
    {

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

        }, []);
    }
}
