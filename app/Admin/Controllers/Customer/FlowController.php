<?php

namespace App\Admin\Controllers\Customer;

use App\Canteen\Bls\Users\AccountFlowBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Common\AccountFlowTypeConst;
use App\Library\Format\FormatMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Excel;

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
                $item->users ? $item->users->name : '-',
                AccountFlowTypeConst::getDesc($item->type),
                AccountFlowTypeConst::getIconDesc($item->type).FormatMoney::fen2yuan($item->amount),
                $item->describe,
                $item->created_at
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
}
