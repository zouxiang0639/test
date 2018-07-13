<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\Administrator;
use App\Admin\Bls\BasicBls;
use App\Admin\Bls\Common\Traits\RelationTraits;
use Redirect;

/**
 * Class AdminUserBls.
 */
class AdminUserBls extends BasicBls
{
    use RelationTraits;

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
            $only = ['roles', 'permissions'];

            $model = Administrator::with($only)->findOrFail($id);

            static::updateRelation($model, $request->only($only));

            $model->username = $request->username;
            $model->name = $request->name;
            if($request->password) {
                $model->password =  bcrypt($request->password);
            }

            return $model->touch();
        });
    }

    public static function storeAdminUser()
    {

    }

}

