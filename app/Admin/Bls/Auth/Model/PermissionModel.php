<?php

namespace App\Admin\Bls\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_permissions';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'http_method' => 'array',
    ];

    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'admin_role_permissions', 'permission_id', 'role_id');
    }

    /**
     * Permission belongs to many user.
     *
     * @return BelongsToMany
     */
    public function adminUser()
    {
        return $this->belongsToMany(AdministratorModel::class, 'admin_user_permissions', 'permission_id', 'user_id');
    }

}
