<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\MenuModel;
use App\Admin\Bls\Auth\Model\PermissionModel;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Widgets\Tree;
use Admin;

/**
 * Class RoleBls.
 */
class MenuBls
{
    static $branchOrder = 1;

    /**
     * @return Tree
     */
    public static function treeView()
    {

        return Admin::tree(new MenuModel(), function (Tree $tree) {
            $tree->setDate(function(MenuModel $query){
                return $query->orderBy('order', 'asc');
            })->toArray()->setItems();

            $tree->setView([
                'tree'   => 'admin::auth.menu.tree.menu',
                'branch' => 'admin::auth.menu.tree.menu_branch',
            ]);
            $tree->path = route('m.menu.sort');

            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                if (!isset($branch['children'])) {
                    if (url()->isValidUrl($branch['url'])) {
                        $url = $branch['url'];
                    } else {
                        $url = $branch['url'];
                    }

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$url\" class=\"dd-nodrag\">$url</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * 存储菜单数据
     * @param MenuRequest $request
     * @return mixed
     */
    public static function storeMenu(MenuRequest $request)
    {
        return MenuModel::query()->getQuery()->getConnection()->transaction(function () use($request) {

            //开启同时创建权限
            if($request->permissions == WhetherConst::YES) {

                //如果权限标签已存在输出错误信息
                $count = PermissionModel::where('slug', $request->slug)->count();
                if($count > 0) {
                    throw new LogicException(1010002, '权限标识已存在');
                }

                $permissions = new PermissionModel();
                $permissions->name = $request->title;
                $permissions->slug = $request->slug;
                $permissions->save();
            }

                $model = new MenuModel();
                $model->parent_id = $request->parent_id;
                $model->title = $request->title;
                $model->icon = $request->icon;
                $model->slug = $request->slug;
                if($request->route) {
                    $model->route = $request->route;
                    $model->url = \Route::has($request->route) ? route($request->route, [], false) : $model->route;
                }

            if($model->save()){
                return $model;
            }
            return false;
        });

    }

    /**
     * 更新菜单数据
     * @param MenuRequest $request
     * @param Menu $model
     * @return mixed
     */
    public static function updateMenu(MenuRequest $request, MenuModel $model)
    {
        $model->parent_id = $request->parent_id;
        $model->title = $request->title;
        $model->icon = $request->icon;
        $model->slug = $request->slug;
        if($request->route) {
            $model->route = $request->route;
            $model->url = \Route::has($request->route) ? route($request->route, [], false) :  $model->route;
        }
        return $model->save();
    }

    /**
     * 获取菜单select数据
     * @return \Illuminate\Support\Collection
     */
    public static function selectOptions()
    {

        $array =  Admin::tree(new MenuModel(), function (Tree $tree) {
            $tree->setDate(function (MenuModel $query) {
                return $query->orderBy('order', 'asc');
            })->toArray()->setItems(Tree::BUILD_SELECT_OPTIONS);
        })->getItems();
        return collect($array)->prepend('Root', 0)->all();
    }


    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return MenuModel::find($id);

    }


    public static function sort($sort)
    {
        $tree = json_decode($sort, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        static::saveOrder($tree);
        return true;
    }

    /**
     * Save tree order from a tree like array.
     *
     * @param array $tree
     * @param int   $parentId
     */
    public static function saveOrder($tree = [], $parentId = 0)
    {


        foreach ($tree as $branch) {
            $model = static::find($branch['id']);
            $model->parent_id = $parentId;
            $model->order = static::$branchOrder ++;

            $model->save();

            if (isset($branch['children'])) {
                static::saveOrder($branch['children'], $branch['id']);
            }
        }
    }

    /**
     * 获取menu树数据
     * @return mixed
     */
    public static function menuTree()
    {

       return Admin::tree(new MenuModel(), function (Tree $tree) {
            $tree->setDate(function (MenuModel $query) {
                return $query->orderBy('order', 'asc');
            })->toArray()->setItems();
        })->getItems();
    }

}

