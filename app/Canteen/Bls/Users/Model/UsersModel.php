<?php

namespace App\Canteen\Bls\Users\Model;

use App\Admin\Bls\System\Model\TagsModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
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

    /**
     * 分组
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions()
    {
        return $this->belongsTo(TagsModel::class, 'division')->withTrashed();
    }

}
