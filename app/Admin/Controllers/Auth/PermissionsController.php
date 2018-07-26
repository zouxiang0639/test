<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\PermissionsBls;
use App\Admin\Bls\Auth\Requests\PermissionsRequest;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
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
        $model = PermissionsBls::permissionsList($request);

        return View::make('admin::auth.permissions.index',[
            'list' => $model
        ]);
    }

    /**
     * 创建
     * @return View
     */
    public function create()
    {
        return View::make('admin::auth.permissions.create',[
            'form' =>  $this->form([]),
        ]);
    }

    /**
     * 存储
     * @param PermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(PermissionsRequest $request)
    {
        if(PermissionsBls::storePermissions($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }


    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = PermissionsBls::find($id);
        $this->isEmpty($model);

        return View::make('admin::auth.permissions.edit',[
          'form' =>  $this->form($model),
          'info' =>  $model
        ]);
    }

    /**
     * @param PermissionsRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(PermissionsRequest $request, $id)
    {

        if(PermissionsBls::updatePermissions($request, $id)) {
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
        if(PermissionsBls::destroyPermissions($id)) {
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
        return Admin::form(function($item) use ($info)  {

            $item->create('名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                $h->set('name', true);
            });

            $item->create('标识', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('slug', array_get($info, 'slug'), $h->options);
                $h->set('slug', true);
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
