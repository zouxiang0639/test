<?php

namespace App\Bls\Auth;

use App\Bls\Auth\Model\Administrator;
use Redirect;

/**
 * Class AdminUserBls.
 */
class AdminUserBls
{
    public static function getAdminUser(Redirect $request, $order = '`id` DESC', $limit = 20)
    {
        $model = Administrator::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function find($id)
    {
       return Administrator::where('id', $id)->first();
    }


    /**
     * 更新后台管理员
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function updateAdminUser($request, $id)
    {
        return Administrator::query()->getQuery()->getConnection()->transaction(function () use($request, $id) {
            $relations = ['roles', 'permissions'];
            $model = Administrator::with($relations)->findOrFail($id);
            static::updateRelation($model, $request->only($relations));

            $model->username = $request->username;
            $model->name = $request->name;
            if($request->password) {
                $model->password =  bcrypt($request->password);
            }

            return $model->save();
        });
    }


    /**
     * 关联数据更新
     * @param $model
     * @param $relationsData
     */
    private static function updateRelation($model, $relationsData)
    {
        foreach($relationsData as $name => $value) {
            if(is_null($value)) {
                continue;
            }
            $relation = $model->$name();
            $relation->sync($value);
        }

    }
}

