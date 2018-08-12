<?php

namespace App\Canteen\Bls\Users\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 */
class OrderModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order';

    public function orderTakeout()
    {
        return $this->hasMany(OrderTakeoutModel::class, 'order_id');
    }

}
