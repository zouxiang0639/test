<?php

namespace App\Admin\Bls\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

}
