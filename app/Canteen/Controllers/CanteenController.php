<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Canteen\TakeoutBls;
use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Auth;

class CanteenController extends Controller
{
    public function takeout()
    {
        $list = TakeoutBls::getTakeoutList();

        $list->each(function($item) {
            $item->formatPrice = FormatMoney::fen2yuan($item->price);
            $item->picture = uploads_path($item->picture);
            $item->json = [
                'stock' => $item->stock,
                'title' => $item->title,
                'price' => $item->price,
                'deposit' => $item->deposit,
                'limit' => $item->limit,
                'id' => $item->id,
                'num' => 0,
            ];
        });

        $json = [];
        foreach($list as $item) {
            $json[$item->id] = $item->json;
        }

        return view('canteen::canteen.takeout', [
            'list' => $list,
            'json' => json_encode($json),
            'takeoutDeadlineCheck' => date('Y-m-d') <= config('config.takeout_deadline')
        ]);
    }

    public function takeoutBuy(Request $request)
    {

        $data = [];
        $error = [];
        $amount = 0;
        $deposit = 0;

        if(empty($request->data)) {
            throw new LogicException(1010001, '请选择外卖');
        }

        foreach($request->data as $value) {
            $model = TakeoutBls::find($value['id']);
            if($model->status != WhetherConst::YES) {
                $error[] = $value['title'].'外卖已被关闭';
            } else if(($model->stock - $value['num']) < 0) {
                $error[] = $value['title'].'库存不够';
            } else if($model->limit < $value['num']) {
                $error[] = $value['title'].'你已超出购买量';
            }

            $amount += $model->price * $value['num'];
            $deposit += $model->deposit * $value['num'];

            $data[] = $value;
        }

        if($error) {
            throw new LogicException(1010001, implode('<br>', $error));
        }

        $money = Auth::guard('canteen')->user()->money;

        if(($money - $amount) < 0) {
            throw new LogicException(1010001, '你的账户金额不足');
        }

        if(OrderBls::createTakeoutOrder($data, $amount, $deposit)){
            return (new JsonResponse())->success('支付成功');
        } else {
            throw new LogicException(1010001, '支付失败');
        }
    }

    public function meal()
    {
        return view('canteen::canteen.meal');
    }
}
