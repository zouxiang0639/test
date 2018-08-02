<?php

namespace App\Forum\Bls\Article\Model;

use App\Forum\Bls\Users\Model\UsersModel;
use Illuminate\Database\Eloquent\Model;

class ReplyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reply';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'thumbs_up' => 'array',
        'thumbs_down' => 'array',
    ];

    /**
     * 发布人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issuers()
    {
        return $this->belongsTo(UsersModel::class, 'issuer');
    }

    /**
     * @的人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ats()
    {
        return $this->belongsTo(UsersModel::class, 'at');
    }

}
