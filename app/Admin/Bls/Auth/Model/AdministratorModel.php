<?php

namespace App\Admin\Bls\Auth\Model;

use App\Consts\Admin\Role\RoleSlugConst;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class AdministratorModel extends Model implements AuthenticatableContract
{
    use Authenticatable;


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if ($avatar) {
            return $avatar;
        }

        return 'user2-160x160.jpg';
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'admin_role_users', 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'admin_user_permissions', 'user_id', 'permission_id');
    }


    /**
     * Determine whether the user has role that given by name parameter.
     *
     * @param $name
     *
     * @return bool
     */
    public function is($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name || $role->slug == $name || $role->id == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can do specific permission that given by name parameter.
     *
     * @param $name
     *
     * @return bool
     */
    public function can($name)
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->name == $name || $permission->slug == $name || $permission->id == $name) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 判断是否有用户权限
     * @param $name
     * @return bool
     */
    public function isPermissions($name)
    {
        $permissions = $this->permissions;
        foreach($permissions as $value){
            if ($value->name == $name || $value->slug == $name || $value->id == $name) {

                return true;
            }
        }

    }


    /**
     * If visible for roles.
     *
     * @param $slug
     *
     * @return bool
     */
    public function visible($slug)
    {
        if (empty($slug)) {
            return true;
        }

        return $this->is(RoleSlugConst::ROLE_SUPER) || $this->can($slug) || $this->isPermissions($slug);
    }

    /**
     * Get all permissions of user.
     *
     * @return mixed
     */
    public function allPermissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->merge($this->permissions);
    }


}
