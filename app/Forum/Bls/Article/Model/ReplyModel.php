<?php

namespace App\Forum\Bls\Article\Model;

use App\Forum\Bls\Users\Model\UsersModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReplyModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reply';

    protected $dates = ['deleted_at'];

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

    public function article()
    {
        return $this->belongsTo(ArticleModel::class, 'article_id')->withTrashed();
    }

    public function child()
    {
        return $this->hasMany(static::class, 'parent_id', 'id')->withTrashed();
    }

    public function parent()
    {
        return $this->hasOne(static::class,  'id', 'parent_id')->withTrashed();
    }

}
