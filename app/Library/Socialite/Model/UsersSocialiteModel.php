<?php

namespace App\Library\Socialite\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 *
 */
class UsersSocialiteModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_socialite';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
