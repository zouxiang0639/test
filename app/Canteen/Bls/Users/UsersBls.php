<?php

namespace App\Canteen\Bls\Users;
use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Canteen\Bls\Users\Model\UsersModel;
use App\Consts\Common\WhetherConst;
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
        $model->password = bcrypt('123456');
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

    public static function usersAll()
    {
        return UsersModel::all();
    }
}
