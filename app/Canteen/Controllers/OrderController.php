<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Order\OrderStatusConst;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $list = OrderBls::getOrderList($request);
        $list->getCollection()->each(function($item) {
            $item->formatAmount = FormatMoney::fen2yuan($item->amount);
            $item->formatDeposit = FormatMoney::fen2yuan($item->deposit);
            $item->statusName = OrderStatusConst::getDesc($item->status);
            $item->child = $item->orderTakeout;
        });
        return view('canteen::order.index', [
            'list' => $list
        ]);
    }


}
