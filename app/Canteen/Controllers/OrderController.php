<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function index(Request $request)
    {
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
        return view('canteen::order.index', [
            'list' => $list
        ]);
    }


}
