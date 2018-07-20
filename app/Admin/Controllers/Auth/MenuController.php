<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\MenuBls;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Auth\AdminUserBls;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use App\Library\Admin\Form\FormBuilder;
use Admin;
use View;

class MenuController extends Controller
{

    public function index()
    {
        $list = MenuBls::treeView();

        return view('admin::auth.menu.index',[
            'list' => $list,
            'form' =>  $this->form([]),
        ]);
    }

    public function store(MenuRequest $request)
    {
        if(MenuBls::storeMenu($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    public function edit($id)
    {
        $model = AdminUserBls::find($id);
        return View::make('admin::auth.user.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    public function update(MenuRequest $request, $id)
    {

        if(AdminUserBls::updateAdminUser($request, $id)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    public function destroy($id)
    {
        $model = MenuBls::find($id);
        if(!$model) {
            throw new LogicException(1010002, '参数错误');
        }

        if(!$model->children->isEmpty()) {
            throw new LogicException(1010002, '请删除子菜单后才可以删除');
        }

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
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

            $item->create('父级菜单', function($h, FormBuilder $form) use ($info){
                $h->input = $form->Select2('parent_id',  MenuBls::selectOptions(), array_get($info, 'parent_id'), $h->options);
                $h->set('parent_id', true);
            });

            $item->create('标题', function($h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('图标', function($h, FormBuilder $form) use ($info){
                $h->input = $form->icon('icon', '', $h->options);
                $h->set('password', true);
                $h->helpBlock = '更多请浏览这个网站 http://fontawesome.io/icons/';
            });

            $item->create('路由', function($h, FormBuilder $form) use ($info){
                $h->input = $form->text('route','', $h->options);
                $h->set('route', true);
                $h->helpBlock = '路由只能是路由别名,http,https';
            });

        })->getFormHtml();
    }
}
