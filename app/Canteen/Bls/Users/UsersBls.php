<?php

namespace App\Canteen\Bls\Users;
use App\Api\Bls\Users\Requests\SitePaymentRequests;
use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Canteen\Bls\Users\Model\UsersModel;
use App\Consts\Common\AccountFlowTypeConst;
use App\Consts\Common\MealTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Format\FormatMoney;
use Illuminate\Http\Request;

/**
 * Created by UsersBls.
 * @author: zouxiang
 * @date:
 */
class UsersBls
{
    /**
     * 获取用户列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getUsersList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = UsersModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        if(!empty($request->division)) {
            $model->where('division', $request->division);
        }

        if(!empty($request->mobile)) {
            $model->where('mobile', $request->mobile);
        }

        if(!empty($request->name)) {
            $model->where('name', $request->name);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 存储用户
     * @param UsersRegisterRequests $requests
     * @return bool
     */
    public static function storeUsers(UsersRegisterRequests $requests)
    {
        $model = new UsersModel();
        $model->division = $requests->tag;
        $model->name = $requests->name;
        $model->mobile = $requests->mobile;
        $model->password = bcrypt(config('admin.user_password'));
        $model->status = WhetherConst::YES;
        return $model->save();
    }

    /**
     * 更新用户列表
     * @param $model
     * @param $request
     * @return mixed
     */
    public static function updateUsers($model, $request)
    {
        $model->division = $request->division;
        $model->status = $request->status;
        return $model->save();
    }

    public static function find($id)
    {
        return UsersModel::find($id);
    }
    public static function getUserByDivision($division)
    {
        return UsersModel::whereIn('division', $division)->get();
    }

    public static function usersAll()
    {
        return UsersModel::all();
    }

    /**
     * 根据手机号获取一条用户信息
     * @param $mobile
     * @return mixed
     */
    public static function getUsersByMobile($mobile)
    {
        $model = UsersModel::query();
        $model->where('mobile', $mobile);
        $model->where('status', WhetherConst::YES);
        $model->select('id', 'mobile', 'money', 'division', 'name', 'remember_token');
        return $model->first();
    }

    /**
     * 现场支付
     * @param $model
     * @param SitePaymentRequests $request
     * @return mixed
     */
    public static function payment($model, SitePaymentRequests $request)
    {
        return UsersModel::query()->getQuery()->getConnection()->transaction(function () use($model, $request) {

            $typeName = MealTypeConst::getDesc($request->type);
            if($request->type == MealTypeConst::STORE) {
                $describe = $typeName . '付款';
            } else {
                $describe = date('Y-m-d') . $typeName . ':'  . $request->num . '份';
            }

            AccountFlowBls::createAccountFlow($model->id, AccountFlowTypeConst::PAYMENT, $request->amount, $describe);

            return $model->save();
        });
    }

    /**
     * 充值
     * @param $items
     * @param $money
     * @param $describe
     * @return mixed
     */
    public static function recharge($items, $money, $describe)
    {

        return UsersModel::query()->getQuery()->getConnection()->transaction(function () use($items, $money, $describe) {

            $describe = $describe ?: '系统充值';

            foreach($items as $value) {
                $value->money += $money;
                if(!$value->save()){
                    throw new LogicException(1010002, '充值错误');
                }
                $price = FormatMoney::fen2yuan($value->money);
                $describes = $describe . "(余额:{$price})";
                AccountFlowBls::createAccountFlow($value->id, AccountFlowTypeConst::RECHARGE, $money, $describes);
            }

            return true;
        });
    }
}
