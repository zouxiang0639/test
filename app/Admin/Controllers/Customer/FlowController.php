<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\Customer\Requests\FlowDeductMoneyRequests;
use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\AccountFlowBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Customer\RechargeTypeConst;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\AccountFlowTypeConst;
use App\Consts\Common\MealTypeConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Excel;
use Admin;

/**
 * Created by FlowController.
 * @author: zouxiang
 * @date:
 */
class FlowController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $usersList = UsersBls::usersAll()->pluck('name', 'id')->toArray();
        $model = AccountFlowBls::gitAccountFlow($request);
        $model->getCollection()->each(function($item) use ($usersList) {
            $item->userName = array_get($usersList, $item->user_id);
            $item->formatAmount = AccountFlowTypeConst::getIconDesc($item->type).FormatMoney::fen2yuan($item->amount);
            $item->typeName = AccountFlowTypeConst::getDesc($item->type);
            $item->useTypeName = MealTypeConst::getDesc($item->use_type) ?: '-';
        });

        return View::make('admin::customer.flow.index',[
            'list' => $model,
            'usersList' => $usersList
        ]);
    }

    /**
     * 导出账户流水
     * @param Request $request
     */
    public function export(Request $request)
    {
        $model = AccountFlowBls::gitAccountFlow($request, '`id` DESC', 10000);

        $formatData = [];
        foreach($model as $item) {
            $formatData[] = [
                $item->id,
                $item->users->divisions->tag_name,
                $item->users ? $item->users->name : '-',
                AccountFlowTypeConst::getDesc($item->type),
                MealTypeConst::getDesc($item->use_type) ?: '-',
                AccountFlowTypeConst::getIconDesc($item->type).FormatMoney::fen2yuan($item->amount),
                $item->describe,
                $item->created_at,
                $item->users ? $item->users->mobile : '-', //帐号
            ];
        }

        $field[] = array_values(config('excelformat.flow'));
        $data = array_merge($field,$formatData);

        Excel::create('账号流水', function ($excel) use ($data) {
            $excel->sheet('账号流水', function ($sheet) use ($data) {
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
     * 后台扣款
     * @return \Illuminate\Contracts\View\View
     */
    public function deduct()
    {
        $division = UsersBls::groupUserDivision();

        return View::make('admin::customer.flow.deduct',[
            'form' => $this->form([]),
            'division' => json_encode($division),
        ]);
    }

    public function deductMoney(FlowDeductMoneyRequests $request)
    {

        if($request->type == RechargeTypeConst::ONE) {
            $user = UsersBls::find($request->user);
            $item = Collection::make([$user]);
        } else {
            $item = UsersBls::getUserByDivision($request->division);
        }
        $money = FormatMoney::fen($request->money);

        if(UsersBls::deduct($item, $money, $request->describe)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     *
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function(Forms $item) use ($info)  {

            $item->create('扣款金额', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('money', 0,  $h->options);
                $h->set('money', true);
            });

            $item->create('扣款类型', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->options['placeholder'] = '请输入';
                $h->input = $form->select('type',RechargeTypeConst::desc() , '', $h->options);
                $h->set('type', true);
            });
            $item->create('扣款总金额', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->display('用户0 充值总金额0.00');
                $h->id = 'count-money';
                $h->set('divisions', false);
            });
            $item->create('分组', function(HtmlFormTpl $h, FormBuilder $form) {
                $list = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
                $h->input = $form->dualListBox('division[]',$list , '', $h->options);
                $h->id = 'division';
                $h->set('division', true);
            });

            $item->create('用户', function(HtmlFormTpl $h, FormBuilder $form) {
                $list = UsersBls::usersByStatus()->pluck('name', 'id')->toArray();
                $h->input = $form->select2('user', $list , '', $h->options);
                $h->id = 'user';
                $h->set('user', true);
            });

            $item->create('描述', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->textarea('describe', '' , $h->options);
                $h->set('describe', true);
            });

        })->getFormHtml();
    }
}
