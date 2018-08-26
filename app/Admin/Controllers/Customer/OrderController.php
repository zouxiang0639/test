<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\OrderBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\MealTypeConst;
use App\Consts\Common\WhetherConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
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
 * Created by OrderController.
 * @author: zouxiang
 * @date:
 */
class OrderController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $type = OrderTypeConst::desc();
        $status = OrderStatusConst::desc();
        $tagList = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        $model = OrderBls::getOrderList($request);
        $usersList = UsersBls::usersAll()->pluck('name', 'id')->toArray();

        $this->formatDate($model->getCollection());


        return View::make('admin::customer.order.index',[
            'list' => $model,
            'division' => $tagList,
            'type' => $type,
            'status' => $status,
            'usersList' => $usersList
        ]);
    }


    /**
     * 展示
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $model = OrderBls::find($id);
        $this->formatDate(Collection::make([$model]));
        $this->isEmpty($model);
        $model->diifPrice = $model->payment - $model->amount;
        return View::make('admin::customer.order.show',[
            'info' =>  $model
        ]);
    }



    /**
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

            $item->create('姓名', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'name'));
            });

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

    protected function formatDate(Collection $items)
    {
        $items->each(function($item) {
            $item->typeName = OrderTypeConst::getDesc($item->type);
            $item->statusName = OrderStatusConst::getDesc($item->status);
            $item->amountFormat = FormatMoney::fen2yuan($item->amount);
            $item->depositFormat = FormatMoney::fen2yuan($item->deposit);
            $item->paymentFormat = FormatMoney::fen2yuan($item->payment);
            $item->userName = '-';

            if($item->type == OrderTypeConst::MEAL) {
                $item->child  = Collection::make([$item->orderMeal])->each(function($item) {
                    $item->name = $item->date.MealTypeConst::getDesc($item->type);
                    $item->price = FormatMoney::fen2yuan($item->price) ;
                });
            } else {
                $item->child = $item->orderTakeout->each(function($item) {
                    $item->price = FormatMoney::fen2yuan($item->price) ;
                    $item->deposit = FormatMoney::fen2yuan($item->deposit) ;
                });;
            }

            if($users = $item->users) {
                $item->userName = $users->name;
            }
        });
    }

}
