<?php

namespace App\Admin\Bls\Auth;

use App\Admin\Bls\Auth\Model\Menu;
use App\Admin\Bls\Auth\Requests\MenuRequest;
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

        return Admin::tree(new Menu(), function (Tree $tree) {
            $tree->setDate(function(Menu $query){
                return $query;
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
        $model = new Menu();
        $model->parent_id = $request->parent_id;
        $model->title = $request->title;
        $model->icon = $request->icon;
        $model->slug = $request->slug;
        $model->route = $request->route;
        $model->url = \Route::has($request->route) ? route($request->route, [], false) :  $model->route;
        return $model->save();

    }

    /**
     * 更新菜单数据
     * @param MenuRequest $request
     * @param Menu $model
     * @return mixed
     */
    public static function updateMenu(MenuRequest $request, Menu $model)
    {
        $model->parent_id = $request->parent_id;
        $model->title = $request->title;
        $model->icon = $request->icon;
        $model->icon = $request->slug;
        $model->route = $request->route;
        $model->url = \Route::has($request->route) ? route($request->route, [], false) :  $model->route;
        return $model->save();
    }

    /**
     * 获取菜单select数据
     * @return \Illuminate\Support\Collection
     */
    public static function selectOptions()
    {
        return Admin::tree(new Menu(), function (Tree $tree) {
            $tree->setDate(function (Menu $query) {
                return $query;
            })->toArray()->setItems(Tree::BUILD_SELECT_OPTIONS);
        })->getItems();
    }


    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return Menu::find($id);

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
       return Admin::tree(new Menu(), function (Tree $tree) {
            $tree->setDate(function (Menu $query) {
                return $query;
            })->toArray()->setItems();
        })->getItems();
    }

}

