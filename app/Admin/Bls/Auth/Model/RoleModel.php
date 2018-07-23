<?php

namespace App\Admin\Bls\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Created by Role.
 * @author: zouxiang
 * @date:
 */
class RoleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_roles';

    /**
     * A role belongs to many users.
     *
     * @return BelongsToMany
     */
    public function administrators()
    {
        return $this->belongsToMany(AdministratorModel::class, 'admin_role_users', 'role_id', 'user_id');
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'admin_role_permissions', 'role_id', 'permission_id');
    }




}
