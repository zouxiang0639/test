<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Canteen\RecipesBls;
use App\Canteen\Bls\Canteen\TakeoutBls;
use App\Canteen\Bls\Users\OrderBls;
use App\Consts\Common\MealTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Auth;

class CanteenController extends Controller
{
    /**
     * 外面展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * 外面购买
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
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

    /**
     * 点餐购买
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function mealBuy(Request $request)
    {
        if(empty($request->num)) {
            throw new LogicException(1010001, '请选择数量');
        }
        if(empty($request->recipes_id)) {
            throw new LogicException(1010001, $request->date . '没有设置菜单不可以订购');
        }

        $name = MealTypeConst::getDesc($request->type);
        $price = MealTypeConst::getPriceDesc($request->type);
        $this->isEmpty($name);

        $amount = ((($request->num - 1) * ($price * 2)) + $price) * $request->discount;
        $deposit = config('config.meal_deposit');

        $data = [
            'type' => $request->type,
            'date' => $request->date,
            'num' => $request->num,
            'price' => $request->price,
            'recipes_id' => $request->recipes_id,
            'discount' => $request->discount * 100
      ];

        $money = Auth::guard('canteen')->user()->money;

        if(($money - $amount) < 0) {
            throw new LogicException(1010001, '你的账户金额不足');
        }

        if(OrderBls::createMealOrder($data, $amount, $deposit)){
            return (new JsonResponse())->success('支付成功');
        } else {
            throw new LogicException(1010001, '支付失败');
        }
    }

    /**
     * 点餐展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws LogicException
     */
    public function meal(Request $request)
    {

        if(empty($request->date)) {
            $request->merge([
                'date' => date('Y-m-d')
            ]);
        }

        $menu = $this->menu();

        $checkMenu = array_values($menu);

        if(!in_array($request->date, $checkMenu)) {
            throw new LogicException(1010001);
        }
        //date_default_timezone_set('PRC');
        unset($checkMenu[0]);

        $key = array_search($request->date, $checkMenu);
        if($key == 2) {
            $check = 2;
        } else if($key == 1 && intval(date('H'))  > intval(config('config.meal_deadline'))){
            $check = 1;
        } else {
            $check = 0;
        }

        $model = RecipesBls::getRecipesByDate($request->date);
        $data = [
            'type' => MealTypeConst::desc(),
            'price' => MealTypeConst::priceDesc(),
            'discount' => [
                1 => config('config.meal_discount1'),
                2 => config('config.meal_discount2')
            ]
        ];
        return view('canteen::canteen.meal', [
            'info' => $model,
            'menu' => $this->menu(),
            'checkMenu' => $checkMenu,
            'date' => $request->date,
            'check' => $check,
            'data' => json_encode($data),
            'deposit' => FormatMoney::fen2yuan(config('config.meal_deposit')),
        ]);
    }

    public function mealOrder(Request $request)
    {

//        $date=new \DateTime();
//        $date->modify('this week');
//        $first_day_of_week=$date->format('Y-m-d');
//        $date->modify('this week +6 days');
//        $end_day_of_week=$date->format('Y-m-d');
//        dd($first_day_of_week, $end_day_of_week);
        $menu = $this->menu();

        $diff = array_values($menu);
        unset($diff[0]);
        if(!in_array($request->date, $diff)) {
            throw new LogicException(1010001);
        }

        $model = RecipesBls::getRecipesByDate($request->date);
        $this->isEmpty($model);

        return view('canteen::canteen.meal_tomorrow', [
            'info' => $model,
            'menu' => $this->menu(),
            'date' => $request->date
        ]);
    }

    /**
     * 菜单
     * @return array
     */
    protected function menu()
    {
        return [
            '今天' => date('Y-m-d'),
            '明天订购' => date("Y-m-d",strtotime("+1 day")),
            '后天订购' => date("Y-m-d",strtotime("+2 day"))
        ];
    }
}
