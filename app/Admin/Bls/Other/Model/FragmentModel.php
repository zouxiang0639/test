<?php

namespace App\Admin\Bls\Other\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FragmentModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_fragment';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extend' => 'array',
    ];


    /**
     * 管理用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
