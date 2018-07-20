<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\PermissionsBls;
use App\Admin\Bls\Auth\Requests\PermissionsRequest;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Redirect;
use Admin;
use View;

class PermissionsController extends Controller
{


    /**
     * @var array
     */
    public $httpMethods = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD',
    ];

    /**
     * 列表
     */
    public function index(Redirect $request)
    {
        $model = PermissionsBls::permissionsList($request);
        $model->getCollection()->each(function($item){
            $item->http_path = explode("\r", $item->http_path);
        });

        return view('admin::auth.permissions.index',[
            'list' => $model
        ]);
    }

    /**
     * 创建
     * @return View
     */
    public function create()
    {
        return view('admin::auth.permissions.create',[
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
            throw new LogicException(1010002, ['操作失败']);
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
            $form = $item->form;

            $item->create('名称', function($h) use ($form, $info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                $h->set('name', true);
            });

            $item->create('标识', function($h) use ($form, $info){
                $h->input = $form->text('slug', array_get($info, 'slug'), $h->options);
                return $h->set('slug', true);
            });

            $item->create('HTTP方法', function($h) use ($form, $info){
                $array =  array_combine($this->httpMethods, $this->httpMethods);
                $h->input = $form->multipleSelect('http_method[]', $array, array_get($info, 'http_method'), $h->options);
                $h->set('http_method', '', '为空默认为所有方法');
            });

            $item->create('HTTP路径', function($h) use ($form, $info){
                $h->input = $form->textarea('http_path', array_get($info, 'http_path'), $h->options);
                $h->set('http_path', true);
            });

        })->getFormHtml();
    }
}
