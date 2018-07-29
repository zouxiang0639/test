<?php

namespace App\Forum\Bls\Users\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';


}
