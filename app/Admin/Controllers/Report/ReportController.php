<?php

namespace App\Admin\Controllers\Report;

use App\Canteen\Bls\Users\Model\OrderModel;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use App\Http\Controllers\Controller;
use Excel;

class ReportController extends Controller
{
    /**
     * 就餐预约统计
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function meal()
    {
        $data = $this->getMeal();
        $item = [];

        foreach($data as $key => $value) {
            foreach($value as $k => $v) {
                $item[] = [
                    'date' => $key,
                    'name' => MealTypeConst::getDesc($k),
                    'num' => $v
                ];
            }
        }

        return view('admin::report.meal', [
            'list' => $item
        ]);
    }

    /**
     * 导出预约就餐
     */
    public function mealExport()
    {
        $data = $this->getMeal();
        $item = [];

        foreach($data as $key => $value) {
            foreach($value as $k => $v) {
                $item[] = [
                    $key,
                    MealTypeConst::getDesc($k),
                    $v
                ];
            }
        }

        $field[] = array_values(config('excelformat.report_meal'));
        $data = array_merge($field, $item);
        Excel::create('就餐预约统计', function ($excel) use ($data) {
            $excel->sheet('就餐预约统计', function ($sheet) use ($data) {
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
     * 本周外卖统计
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function takeout()
    {
        return view('admin::report.takeout', [
            'list' => $this->getTakeout()
        ]);
    }

    /**
     *  导出本周外卖菜单
     */
    public function takeoutExport()
    {
        $item = [];
        $data = $this->getTakeout();
        foreach($data as $value) {
            $item[] = [
                $value['name'],
                $value['num'],
            ];
        }

        $field[] = array_values(config('excelformat.report_takeout'));
        $data = array_merge($field, $item);
        Excel::create('本周外卖统计', function ($excel) use ($data) {
            $excel->sheet('本周外卖统计', function ($sheet) use ($data) {
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
     *  导出本周用户外卖菜单
     */
    public function takeoutUserExport()
    {

        $order = OrderModel::with(['orderTakeout'])
            ->where('type', OrderTypeConst::TAKEOUT)
            ->where('status', OrderStatusConst::DEPOSIT)
            ->get();

        $data = [];
        foreach($order as $item) {
            $orderTakeout = $item->orderTakeout;
            $takeout = [];
            foreach($orderTakeout as $value) {
                $takeout[] = $value->name . '-' . $value->num . '份';
            }
            $data[] = [
                $item->users->name,  //用户名称
                $item->amount,  //总金额(分)
                $item->deposit,  //定金(分)
                implode(chr(10), $takeout),  //外卖
                $item->users ? $item->users->mobile : '-'//帐号
            ];
        }


        $field[] = array_values(config('excelformat.report_user_takeout'));

        $data = array_merge($field, $data);
        Excel::create('本周用户外卖统计', function ($excel) use ($data) {
            $excel->sheet('本周用户外卖统计', function ($sheet) use ($data) {
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

                $sheet ->getStyle('D2:D'.count($data))->getAlignment()->setWrapText(true);
            });
        })->export('xls');
    }

    /**
     * 就餐统计数据
     * @return array
     */
    protected function getMeal()
    {
        $order = OrderModel::with(['orderMeal'])->where('status', OrderStatusConst::DEPOSIT)->where('type', OrderTypeConst::MEAL)->get();
        $data = [];
        foreach($order as $items) {
            if($meal = $items->orderMeal) {

                if(isset($data[$meal->date][$meal->type])) {
                    $data[$meal->date][$meal->type] += $meal->num;
                } else {
                    $data[$meal->date][$meal->type] = $meal->num;
                }
            }
        }
        return $data;
    }

    /**
     * 本周外卖统计数据
     * @return array
     */
    protected function getTakeout()
    {
        $item = [];
        
        $order = OrderModel::with(['orderTakeout'])
            ->where('type', OrderTypeConst::TAKEOUT)
            ->where('status', OrderStatusConst::DEPOSIT)
            ->get();

        foreach($order as $orderModel) {
            if($orderTakeout = $orderModel->orderTakeout) {
                foreach($orderTakeout as $value) {

                    if(isset($item[$value->takeout_id])) {
                        $item[$value->takeout_id]['num'] += $value->num;
                    } else {
                        $item[$value->takeout_id] = [
                            'name' => $value->name,
                            'num' => $value->num
                        ];
                    }
                }
            }
        }

        return $item;
    }
}
