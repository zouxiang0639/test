<?php

namespace App\Admin\Bls\Canteen;

use App\Admin\Bls\Canteen\Model\TakeoutModel;
use App\Admin\Bls\Canteen\Requests\TakeoutRequest;
use App\Library\Format\FormatMoney;
use Illuminate\Http\Request;


class TakeoutBls
{
    /**
     * 获取外卖列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getTakeoutList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = TakeoutModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function storeTakeout(TakeoutRequest $request)
    {
        $model = new TakeoutModel();
        $model->title = $request->title;
        $model->status = $request->status;
        $model->picture = $request->picture;
        $model->stock = $request->stock;
        $model->price = FormatMoney::fen($request->price);
        $model->deposit = FormatMoney::fen($request->deposit);
        $model->limit = $request->limit;
        $model->describe = $request->describe ?: '';
        return $model->save();
    }

    public static function updateTakeout(TakeoutRequest $request, TakeoutModel $model)
    {
        $model->title = $request->title;
        $model->status = $request->status;
        $model->picture = $request->picture;
        $model->stock = $request->stock;
        $model->price = FormatMoney::fen($request->price);
        $model->deposit = FormatMoney::fen($request->deposit);
        $model->limit = $request->limit;
        $model->describe = $request->describe ?: '';
        return $model->save();
    }

    public static function find($id)
    {
        return TakeoutModel::find($id);
    }

}