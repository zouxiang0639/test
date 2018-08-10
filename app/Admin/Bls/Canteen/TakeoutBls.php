<?php

namespace App\Admin\Bls\Canteen;

use App\Admin\Bls\Canteen\Model\TakeoutModel;
use Illuminate\Http\Request;


class TakeoutBls
{
    /**
     * 获取TAG列表
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

}