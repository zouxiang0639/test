<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\Role;
use App\Admin\Bls\BasicBls;

/**
 * Class RoleBls.
 */
class RoleBls extends BasicBls
{

    public static function getRoleList($request, $order = '`id` DESC', $limit = 20)
    {
        $model = Role::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function storeRole($request)
    {
        return Role::query()->getQuery()->getConnection()->transaction(function () use($request) {
            $only = ['permissions'];

            $model = new Role();
            $model->name = $request->name;
            $model->slug = $request->slug;
            $result = $model->save();

            static::updateRelation($model, $request->only($only));

            return $result;
        });
    }

}

