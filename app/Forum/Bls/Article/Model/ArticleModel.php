<?php

namespace App\Forum\Bls\Article\Model;

use App\Forum\Bls\Users\Model\UsersModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'thumbs_up' => 'array',
        'thumbs_down' => 'array',
        'star' => 'array',
        'recommend' => 'array',
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
     * 收藏
     *
     * @return BelongsToMany
     */
    public function articlesStar()
    {
        return $this->belongsToMany(UsersModel::class, 'articles_star', 'articles_id', 'user_id');
    }


}
