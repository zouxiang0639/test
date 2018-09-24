<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\AdministratorModel;
use App\Admin\Bls\Auth\Requests\UserRequest;
use App\Admin\Bls\Common\Traits\RelationTraits;
use Redirect;

/**
 * Class AdminUserBls.
 */
class AdminUserBls
{
    use RelationTraits;

    const ONLY = ['roles', 'permissions'];

    /**
     * 管理员列表
     * @param Redirect $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getAdminUser(Redirect $request, $order = '`id` DESC', $limit = 20)
    {
        $model = AdministratorModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
       return AdministratorModel::where('id', $id)->first();
    }


    /**
     * 更新后台管理员
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function updateAdminUser(UserRequest $request, $id)
    {
        return AdministratorModel::query()->getQuery()->getConnection()->transaction(function () use($request, $id) {
            $only = ['roles', 'permissions'];

            $model = AdministratorModel::with($only)->findOrFail($id);

            static::updateRelation($model, $request->only($only));

            $model->username = $request->username;
            $model->name = $request->name;
            $model->tags = $request->tags;
            if($request->password) {
                $model->password =  bcrypt($request->password);
            }

            return $model->touch();
        });
    }

    /**
     * 存储
     * @param UserRequest $request
     * @return mixed
     */
    public static function storeAdminUser(UserRequest $request)
    {
        return AdministratorModel::query()->getQuery()->getConnection()->transaction(function () use($request) {
            $only = ['roles', 'permissions'];
            $model = new AdministratorModel();
            $model->username = $request->username;
            $model->name = $request->name;
            $model->password = bcrypt($request->password);
            $model->tags = $request->tags;
            $result = $model->save();
            static::updateRelation($model, $request->only($only));

            return $result;
        });
    }

    /**
     * 删除管理员
     * @param $id
     * @return mixed
     */
    public static function destroyAdmin($id)
    {
        return AdministratorModel::query()->getQuery()->getConnection()->transaction(function () use($id) {
            $model = AdministratorModel::with(self::ONLY)->findOrFail($id);
            static::deleteRelation($model, self::ONLY);
            return $model->delete();
        });
    }

}

