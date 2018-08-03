<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\PermissionsBls;
use App\Admin\Bls\Auth\Requests\RoleRequest;
use App\Admin\Bls\Auth\RoleBls;
use App\Admin\Bls\Auth\Model\Permission;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
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

        return View::make('admin::auth.role.index',[
            'list' => $model
        ]);
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin::auth.role.create',[
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
            throw new LogicException(1010002, '操作失败');
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

        $this->isEmpty($model);

        return View::make('admin::auth.role.edit',[
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
        if($id == 1) {
            throw new LogicException(1010002, 'ID为1的不能删除');
        }

        if(RoleBls::destroyRole($id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * @param array $info
     * @return mixed
     */
    protected function form($info = [])
    {

        return Admin::form(function($item) use ($info)  {

            if($info) {
                $item->create('标识', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                    $h->input = $form->display(array_get($info, 'slug'));
                    $h->input .= $form->hidden('slug', array_get($info, 'slug'));
                });
            } else {
                $item->create('标识', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                    $h->input = $form->text('slug', array_get($info, 'slug'), $h->options);
                    $h->set('slug', true);
                });
            }

            $item->create('名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                 $h->set('name', true);
            });

            $item->create('权限', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input =  $form->dualListBox('permissions[]', PermissionsBls::PermissionByName(), array_get($info, 'permissions'),  $h->options);
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
