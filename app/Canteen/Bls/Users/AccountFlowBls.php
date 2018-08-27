<?php

namespace App\Canteen\Bls\Users;

use App\Canteen\Bls\Users\Model\AccountFlowModel;
use Auth;
use Illuminate\Http\Request;

class AccountFlowBls
{

    public static function gitAccountFlowList($limit = 20)
    {
       return AccountFlowModel::where('user_id', Auth::guard('canteen')->id())->orderBy('id','desc')->simplePaginate($limit);
    }

    /**
     * 创建账户流水
     * @param $userId
     * @param $type
     * @param $amount
     * @param $describe
     * @return bool
     */
    public static function createAccountFlow($userId, $type, $amount, $describe)
    {
        $model = new AccountFlowModel();
        $model->user_id = $userId;
        $model->type = $type;
        $model->amount = $amount;
        $model->describe = $describe;
        return $model->save();
    }

    /**
     * 获取账户流水列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function gitAccountFlow(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = AccountFlowModel::query();

        //流水ID
        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        //用户ID
        if(!empty($request->user_id)) {
            $model->where('user_id', $request->user_id);
        }

        //类型
        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        //创建时间
        if(!empty($request->start_time) && !empty( $request->end_time)){
            $model->whereBetween('created_at', [$request->start_time. ' 00:00:00', $request->end_time . ' 23:59:59']);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }
}
