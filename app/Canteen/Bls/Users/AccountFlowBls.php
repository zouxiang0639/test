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

    public static function gitAccountFlow(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = AccountFlowModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        if(!empty($request->user_id)) {
            $model->where('user_id', $request->user_id);
        }

        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }
}
