<?php

namespace App\Admin\Controllers\Other;


use App\Admin\Bls\Other\FragmentBls;
use App\Admin\Bls\Other\Requests\FragmentRequests;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Admin;

/**
 * Created by FragmentController.
 * @author: zouxiang
 * @date:
 */
class FragmentController extends Controller
{

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $list = FragmentBls::getFragmentList($request);


        $list->getCollection()->each(function($item) {
        });

        return View::make('admin::other.fragment.index',[
            'list' => $list,
        ]);
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin::other.fragment.create',[
            'form' =>  $this->form([]),
        ]);
    }

    /**
     * 存储
     * @param FragmentRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(FragmentRequests $request)
    {
        if(FragmentBls::storeFragment($request)) {
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
        $model = FragmentBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::other.fragment.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * @param FragmentRequests $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(FragmentRequests $request, $id)
    {
        $model = FragmentBls::find($id);

        $this->isEmpty($model);

        if(FragmentBls::updateFragment($model, $request)) {
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
        $model = FragmentBls::find($id);

        $this->isEmpty($model);

        if($model->is_lock == WhetherConst::YES) {
            throw new LogicException(1010001, '数据已被锁住不可删除');
        }

        if($model->delete()) {
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
        return Admin::form(function(Forms $item) use ($info) {


            $item->create('标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('图片', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->imageOne('picture', array_get($info, 'picture'), $h->options);
                $h->set('picture', false);
            });

            $item->create('链接', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('links', array_get($info, 'links'), $h->options);
                $h->set('links', false);
            });

            $item->create('内容', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->ckeditor('contents',  array_get($info, 'contents'), $h->options);
                $h->set('contents', false);
            });
        })->getFormHtml();
    }

}
