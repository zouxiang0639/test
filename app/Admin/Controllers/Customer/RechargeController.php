<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\Customer\Requests\RechargeMoneyRequests;
use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\AccountFlowBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Customer\RechargeTypeConst;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\AccountFlowTypeConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Admin;
use Illuminate\Support\Collection;
use View;

/**
 * Created by RechargeController.
 * @author: zouxiang
 * @date:
 */
class RechargeController extends Controller
{


    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $request->merge(['types' => [AccountFlowTypeConst::RECHARGE,AccountFlowTypeConst::HEDGING]]);
        $usersList = UsersBls::usersAll()->pluck('name', 'id')->toArray();
        $model = AccountFlowBls::gitAccountFlow($request);
        $model->getCollection()->each(function($item) use ($usersList) {
            $item->userName = array_get($usersList, $item->user_id);
            $item->formatAmount = AccountFlowTypeConst::getIconDesc($item->type).FormatMoney::fen2yuan($item->amount);
            $item->typeName = AccountFlowTypeConst::getDesc($item->type);
        });

        return View::make('admin::customer.recharge.index',[
            'list' => $model,
            'usersList' => $usersList
        ]);
    }


    /**
     * 充值
     * @return \Illuminate\Contracts\View\View
     */
    public function money()
    {
        return View::make('admin::customer.recharge.money',[
            'form' => $this->form([])
        ]);
    }

    /**
     * 充值提交
     * @param RechargeMoneyRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function moneyPost(RechargeMoneyRequests $request)
    {
        if($request->type == RechargeTypeConst::ONE) {
            $user = UsersBls::find($request->user);
            $item = Collection::make([$user]);
        } else {
            $item = UsersBls::getUserByDivision($request->division);
        }
        $money = FormatMoney::fen($request->money);

        if(UsersBls::recharge($item, $money, $request->describe)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 对冲
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function hedging($id)
    {
        $model = AccountFlowBls::find($id);

        $this->isEmpty($model);

        if($model->hedging_id != 0) {
            throw new LogicException(1010003, '已经对冲');
        }

        if(AccountFlowBls::hedging($model)) {
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

            $item->create('充值金额', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('money', 0,  $h->options);
                $h->set('money', true);
            });

            $item->create('充值类型', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->options['placeholder'] = '请输入';
                $h->input = $form->select('type',RechargeTypeConst::desc() , '', $h->options);
                $h->set('type', true);
            });

            $item->create('分组', function(HtmlFormTpl $h, FormBuilder $form) {
                $list = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
                $h->input = $form->dualListBox('division[]',$list , '', $h->options);
                $h->id = 'division';
                $h->set('division', true);
            });

            $item->create('用户', function(HtmlFormTpl $h, FormBuilder $form) {
                $list = UsersBls::usersAll()->pluck('name', 'id')->toArray();
                $h->input = $form->select2('user', $list , '', $h->options);
                $h->id = 'user';
                $h->set('user', true);
            });

            $item->create('描述', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->textarea('describe', '' , $h->options);
                $h->set('describe', false, '自定义描述填写后将会替换掉系统设置描述');
            });

        })->getFormHtml();
    }

}
