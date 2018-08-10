<?php

namespace App\Admin\Bls\Canteen\Model;

use App\Library\Database\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by ConfigModel.
 * @author: zouxiang
 * @date:
 */
class TakeoutModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'takeout';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
