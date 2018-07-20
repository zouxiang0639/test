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
    /**
     * @return Tree
     */
    public static function treeView()
    {
        $model = new Menu();

        return Admin::tree($model, function (Tree $tree) {
            $tree->setView([
                'tree'   => 'admin::auth.menu.tree.menu',
                'branch' => 'admin::auth.menu.tree.menu_branch',
            ]);

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

    public static function storeMenu(MenuRequest $request)
    {
        $model = new Menu();
        $model->parent_id = $request->parent_id;
        $model->title = $request->title;
        $model->icon = $request->icon;
        $model->route = $request->route;
        $model->url = \Route::has($request->route) ? route($request->route, [], false) :  $model->route;
        return $model->save();

    }

    public static function selectOptions()
    {
        return Menu::selectOptions();
    }

    public static function find($id)
    {
        return Menu::find($id);
    }



}

