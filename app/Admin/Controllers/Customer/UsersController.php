<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Role\RoleSlugConst;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Admin;
use View;
use Excel;
use Auth;

/**
 * Created by UsersController.
 * @author: zouxiang
 * @date:
 */
class UsersController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $tagList = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        $model = UsersBls::getUsersList($request);

        $tag = TagsBls::getTags(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        $model->getCollection()->each(function($item) use ($tag) {
            $item->divisionNmae = array_get($tag, $item->division, '-');
            $item->formatMoney = FormatMoney::fen2yuan($item->money);
        });

        return View::make('admin::customer.users.index',[
            'list' => $model,
            'division' => $tagList
        ]);
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = UsersBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::customer.users.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * 修改外卖状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = UsersBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(Request $request, $id)
    {
        $model = UsersBls::find($id);

        $this->isEmpty($model);

        if(UsersBls::updateUsers($model, $request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }


    public function reset($id)
    {
        $model = UsersBls::find($id);
        $this->isEmpty($model);

        $model->password =  bcrypt(config('admin.user_password'));
        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    public function export(Request $request)
    {
        $model = UsersBls::getUsersList($request, '`id` DESC', 10000);
        $tagList = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        $formatData = [];
        foreach($model as $item) {
            $formatData[] = [
                $item->id,
                $item->name,
                array_get($tagList, $item->division, '-'),
                FormatMoney::fen2yuan($item->money)
            ];
        }

        $field[] = array_values(config('excelformat.user_balance'));
        $data = array_merge($field,$formatData);
        Excel::create('用户余额', function ($excel) use ($data) {
            $excel->sheet('用户余额', function ($sheet) use ($data) {
                $sheet->rows($data);
                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 10);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 10);
                $sheet->setWidth('I', 10);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 30);
                $sheet->setWidth('M', 30);
                $sheet->setWidth('N', 20);
                $sheet->setWidth('O', 20);
                $sheet->setWidth('P', 20);
                $sheet->setWidth('Q', 20);
                $sheet->setWidth('R', 20);
                $sheet->setWidth('S', 10);
                $sheet->setWidth('T', 10);
                $sheet->setWidth('U', 10);
                $sheet->setWidth('V', 30);
                $sheet->setWidth('W', 50);
                $sheet->setWidth('X', 20);
                $sheet->setWidth('Y', 20);
                $sheet->setWidth('Z', 20);
                $sheet->setWidth('AA', 10);
                $sheet->setWidth('AB', 10);
                $sheet->setWidth('AC', 10);
                $sheet->setColumnFormat(array('V' => '@'));
            });
        })->export('xls');
    }

    /**
     * 设置配置
     *
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function(Forms $item) use ($info)  {

            $item->create('用户编号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'id'));
            });


            if(Auth::guard('admin')->user()->is(RoleSlugConst::ROLE_SUPER)) {
                $item->create('名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                    $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                    $h->set('name', true);
                });
            } else {
                $item->create('姓名', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                    $h->input = $form->display(array_get($info, 'name'));
                });
            }


            $item->create('手机号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'mobile'));
            });

            $item->create('余额', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(FormatMoney::fen2yuan(array_get($info, 'money')));
            });

            $item->create('分组', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $list = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
                $h->input = $form->select2('division',$list , array_get($info, 'division'), $h->options);
                $h->set('division', true);
            });

            $item->create('状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('status', array_get($info, 'status'));
                $h->set('status', true);
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });
        })->getFormHtml();
    }

}
