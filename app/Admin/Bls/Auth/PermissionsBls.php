<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\PermissionModel;
use App\Admin\Bls\Auth\Requests\PermissionsRequest;
use App\Exceptions\LogicException;
use Redirect;

/**
 * Created by PermissionsBls.
 * @author: zouxiang
 * @date:
 */
class PermissionsBls
{

    /**
     * 获取权限列表
     * @param Redirect $request
     * @param string $order
     * @param int $limit
     * @return mixed
     */
    public static function permissionsList(Redirect $request, $order = '`id` DESC', $limit = 20)
    {
        $model = PermissionModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 规则存储
     * @param PermissionsRequest $request
     * @return mixed
     */
    public static function storePermissions(PermissionsRequest $request)
    {
        $model = new PermissionModel();
        $model->slug = $request->slug;
        $model->name = $request->name;
        return $model->save();
    }

    public static function updatePermissions(PermissionsRequest $request, $id)
    {
        $model = self::find($id);
        if(!$model) {
            throw new LogicException(1010002, '参数错误');
        }
        $model->slug = $request->slug;
        $model->name = $request->name;
        return $model->save();
    }

    public static function destroyPermissions($id)
    {
        $model = self::find($id);
        if(!$model->roles->isEmpty() || !$model->adminUser->isEmpty()) {
            throw new LogicException(1010002, '权限已经被关联到角色或者用户不可删除');
        }

        return $model->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return PermissionModel::find($id);
    }

    /**
     * 获取所有权限名称
     * @return \Illuminate\Support\Collection
     */
    public static function PermissionByName()
    {
        return PermissionModel::all()->pluck('name', 'id');
    }


}

