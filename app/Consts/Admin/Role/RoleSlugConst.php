<?php

namespace App\Consts\Admin\Role;

class RoleSlugConst
{
    const ROLE_SUPER = "super"; //超级管理员

    /**
     * @name 根据主管获取相应的员工角色
     * @param $superSlug
     * @return string
     */
    public static function getUsersRoleBySupervisor($superSlug)
    {
        switch ($superSlug) {
            default:
                return [];
        }
    }

}