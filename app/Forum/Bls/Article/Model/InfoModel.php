<?php

namespace App\Forum\Bls\Article\Model;

use App\Forum\Bls\Users\Model\UsersModel;
use Illuminate\Database\Eloquent\Model;

class InfoModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'info';

    /**
     * 接收人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }

    /**
     * 接收人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator()
    {
        return $this->belongsTo(UsersModel::class, 'operator_id');
    }
    public function articles()
    {
        return $this->belongsTo(ArticleModel::class, 'articles_id')->withTrashed();
    }


}
