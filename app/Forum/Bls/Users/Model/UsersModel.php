<?php

namespace App\Forum\Bls\Users\Model;

use App\Consts\Admin\Role\RoleSlugConst;
use App\Forum\Bls\Article\Model\ArticleModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class UsersModel extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 收藏
     *
     * @return BelongsToMany
     */
    public function articlesStar()
    {
        return $this->belongsToMany(ArticleModel::class, 'articles_star', 'user_id', 'articles_id');
    }

    /**
     * 推荐
     *
     * @return BelongsToMany
     */
    public function articlesRecommend()
    {
        return $this->belongsToMany(ArticleModel::class, 'articles_recommend', 'user_id', 'articles_id');
    }
}
