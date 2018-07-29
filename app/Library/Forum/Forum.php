<?php

namespace App\Library\Forum;

use App\Admin\Bls\System\Model\TagsModel;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;

class Forum
{

    public function getTags()
    {
        return TagsModel::where('type', TagsTypeConst::TAG)->where('status', WhetherConst::YES)
            ->get();
    }
}