<?php

namespace App\Forum\Bls\Users\Model;

use App\Consts\Admin\Role\RoleSlugConst;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class UsersModel extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';


}
