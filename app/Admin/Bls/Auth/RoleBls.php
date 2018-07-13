<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\Role;
use App\Admin\Bls\BasicBls;
use App\Admin\Bls\Common\Traits\RelationTraits;
use App\Exceptions\LogicException;

/**
 * Class RoleBls.
 */
class RoleBls extends BasicBls
{
    use RelationTraits;

    const ONLY = ['permissions'];

    /**
     * 角色列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getRoleList($request, $order = '`id` DESC', $limit = 20)
    {
        $model = Role::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }


    public static function find($id)
    {
        return Role::where('id', $id)->first();
    }


    /**
     * 创建角色
     * @param $request
     * @return mixed
     */
    public static function storeRole($request)
    {
        return Role::query()->getQuery()->getConnection()->transaction(function () use($request) {

            $model = new Role();
            $model->name = $request->name;
            $model->slug = $request->slug;
            $result = $model->touch();

            static::updateRelation($model, $request->only(self::ONLY));

            return $result;
        });
    }

    /**
     * 更新角色
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function updateRole($request, $id)
    {
        return Role::query()->getQuery()->getConnection()->transaction(function () use($request, $id) {

            $model = Role::with(self::ONLY)->findOrFail($id);

            static::updateRelation($model, $request->only(self::ONLY));

            $model->name = $request->name;
            $model->slug = $request->slug;
            return $model->touch();
        });
    }

    /**
     * 删除角色
     * @param $id
     * @return mixed
     */
    public static function destroyRole($id)
    {
        return Role::query()->getQuery()->getConnection()->transaction(function () use($id) {

            $model = Role::with(self::ONLY)->findOrFail($id);
            if($model->administrators->count()) {
                throw new LogicException(1010001, '请先解除用户关联的角色');
            }

            static::deleteRelation($model, self::ONLY);

            return $model->delete();
        });
    }
}

