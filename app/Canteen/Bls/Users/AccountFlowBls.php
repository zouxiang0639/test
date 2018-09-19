<?php

namespace App\Canteen\Bls\Users;

use App\Canteen\Bls\Users\Model\AccountFlowModel;
use App\Consts\Common\AccountFlowTypeConst;
use App\Library\Format\FormatMoney;
use Auth;
use Illuminate\Http\Request;

class AccountFlowBls
{

    public static function gitAccountFlowList($limit = 20)
    {
       return AccountFlowModel::where('user_id', Auth::guard('canteen')->id())->orderBy('id','desc')->simplePaginate($limit);
    }

    public static function find($id)
    {
        return AccountFlowModel::find($id);
    }

    /**
     * 创建账户流水
     * @param int $userId 用户ID
     * @param int $type 状态 1支付 2充值 3对冲 AccountFlowType
     * @param int $amount 金额
     * @param string $describe 描述
     * @param int $useType 消费类型 1早餐 2午餐 3晚餐 4超市 5外卖 MealTypeConst
     * @return bool
     */
    public static function createAccountFlow($userId, $type, $amount, $describe, $useType = 0)
    {
        $model = new AccountFlowModel();
        $model->user_id = $userId;
        $model->type = $type;
        $model->amount = $amount;
        $model->describe = $describe;
        $model->use_type = $useType;

        if($model->save()) {
            return $model;
        }

        return false;
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

        //消费类型
        if(!empty($request->use_type)) {
            $model->where('use_type', $request->use_type);
        }

        //类型
        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        //类型数组型
        if(!empty($request->types)) {
            $model->whereIn('type', $request->types);
        }

        //创建时间
        if(!empty($request->start_time) && !empty( $request->end_time)){
            $model->whereBetween('created_at', [$request->start_time. ' 00:00:00', $request->end_time . ' 23:59:59']);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 红字对冲
     * @param AccountFlowModel $model
     * @return mixed
     */
    public static function hedging(AccountFlowModel $model)
    {

        return AccountFlowModel::query()->getQuery()->getConnection()->transaction(function () use($model) {

            $user = $model->users;
            $user->money -= $model->amount;
            $user->save();
            $describe = "对冲ID:$model->id ,余额:".FormatMoney::fen2yuan($user->money);
            $flow = static::createAccountFlow($user->id, AccountFlowTypeConst::HEDGING, $model->amount, $describe);

            $model->hedging_id = $flow->id;

            return $model->save();

        });
    }
}
