<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->merge(['user_id' => Auth::guard('canteen')->id()]);

        $list = OrderBls::getOrderList($request);
        $list->getCollection()->each(function($item) {
            $item->formatAmount = FormatMoney::fen2yuan($item->amount);
            $item->formatDeposit = FormatMoney::fen2yuan($item->deposit);
            $item->formatPayment = FormatMoney::fen2yuan($item->payment);
            $item->statusName = OrderStatusConst::getDesc($item->status);

            if($item->type == OrderTypeConst::MEAL) {
                $item->child  = Collection::make([$item->orderMeal])->each(function($item) {
                    $item->name = $item->date.MealTypeConst::getDesc($item->type);
                    $item->price = FormatMoney::fen2yuan($item->price) ;
                });
            } else {
                $item->child = $item->orderTakeout;
            }


        });

        if($request->ajax()) {
            $view = view('canteen::order.index_ajax',['list' => $list])->render();
            return (new JsonResponse())->success($view);
        }

        return view('canteen::order.index', [
            'list' => $list
        ]);
    }



    public function refund(Request $request)
    {
        $count = OrderBls::countOverdueByTakeout(Auth::guard('canteen')->id());

        $refundLimit = config('config.refund_limit');
        if($count >= $refundLimit) {
            throw new LogicException(1010001, "这个月你已经退单{$count}次, 每个月限制{$refundLimit}次");
        }

        $model = OrderBls::find($request->id);

        $this->isEmpty($model);

        if($model->status != OrderStatusConst::DEPOSIT) {
            throw new LogicException(1010001, "状态参数不对");
        }

        if(OrderBls::refund($model)) {
            return (new JsonResponse())->success('退款成功');
        } else {
            throw new LogicException(1010002, '退款失败');
        }

    }


}
