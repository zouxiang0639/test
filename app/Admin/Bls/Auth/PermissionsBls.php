<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\Permission;
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
        $model = Permission::query();

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
        $model = new Permission();
        $model->slug = $request->slug;
        $model->name = $request->name;
        $model->http_method = $request->http_method;
        $model->http_path = $request->http_path;
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
        $model->http_method = $request->http_method;
        $model->http_path = $request->http_path;
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
        return Permission::find($id);
    }


}

