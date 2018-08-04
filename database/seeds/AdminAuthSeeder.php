<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Auth\Model\AdministratorModel;
use App\Consts\Admin\Role\RoleSlugConst;
use App\Admin\Bls\Auth\Model\RoleModel;
use App\Admin\Bls\Auth\MenuBls;
use App\Admin\Bls\Auth\Model\MenuModel;
use App\Consts\Common\WhetherConst;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Auth\Model\PermissionModel;

class AdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建管理员
        AdministratorModel::truncate();
        $administrator = AdministratorModel::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name'     => '超级管理员',
        ]);

        //创建角色
        RoleModel::truncate();
        $role =  RoleModel::create([
            'name' => '超级管理员',
            'slug' => RoleSlugConst::ROLE_SUPER,
        ]);

        //给超级管理员关联角色
        $administrator->roles()->sync($role);

        //清空权限
        PermissionModel::truncate();


        //创建后台菜单以及权限
        $menuRequest = new MenuRequest();
        MenuModel::truncate();

        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '首页',
            'icon' => 'fa-bar-chart',
            'route' => 'm.home',
            'slug' => '',
            'permissions' => WhetherConst::NO
        ]);
        MenuBls::storeMenu($menuRequest);
        $this->admin(); //后台管理
        $this->system(); //系统管理
    }

    /**
     * 后台管理
     */
    public function admin()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '后台管理',
            'icon' => 'fa-tasks',
            'route' => '',
            'slug' => 'm_auth',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '管理员',
            'icon' => 'fa-users',
            'route' => 'm.user.list',
            'slug' => 'm_auth_users',
            'permissions' => WhetherConst::YES
        ]);

        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '角色',
            'icon' => 'fa-user',
            'route' => 'm.role.list',
            'slug' => 'm_auth_role',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '权限',
            'icon' => 'fa-ban',
            'route' => 'm.permissions.list',
            'slug' => 'm_auth_permissions',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '菜单',
            'icon' => 'fa-bars',
            'route' => 'm.menu.list',
            'slug' => 'm_auth_menu',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);
    }

    /**
     * 系统管理
     */
    public function system()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '系统管理',
            'icon' => 'fa-cogs',
            'route' => '',
            'slug' => 'm_system',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '配置管理',
            'icon' => 'fa-cog',
            'route' => 'm.system.config.set',
            'slug' => 'm_system_config',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '标签',
            'icon' => 'fa-tags',
            'route' => 'm.system.tags.list',
            'slug' => 'm_system_tags',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '系统日志',
            'icon' => 'fa-database',
            'route' => 'm.system.log.list',
            'slug' => 'm_system_log',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '数据备份',
            'icon' => 'fa-copy',
            'route' => 'm.system.backup.list',
            'slug' => 'm_system_log',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

    }
}
