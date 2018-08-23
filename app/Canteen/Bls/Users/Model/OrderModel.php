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

    /**
     * 外面
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderTakeout()
    {
        return $this->hasMany(OrderTakeoutModel::class, 'order_id');
    }

    /**
     * 点餐
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderMeal()
    {
        return $this->belongsTo(OrderMealModel::class, 'id', 'order_id');
    }

    /**
     * 用户关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }

}
