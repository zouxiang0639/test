<?php

namespace App\Forum\Bls\File\Model;

use App\Forum\Bls\Users\Model\UsersModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FileModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file';

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
