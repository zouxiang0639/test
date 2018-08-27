<?php

namespace App\Canteen\Bls\Users\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 */
class AccountFlowModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_flow';



    /**
     * 用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }
}
