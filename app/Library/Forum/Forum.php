<?php

namespace App\Library\Forum;

use App\Admin\Bls\System\Model\TagsModel;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;
use App\Library\Forum\Widgets\Fragment;
use App\Library\Forum\Widgets\Tags;
use DfaFilter\SensitiveHelper;

/**
 * Created by Forum.
 * @author: zouxiang
 * @date:
 */
class Forum
{

    /**
     * @var
     */
    private $fragment;

    public function tags($type = TagsTypeConst::TAG)
    {
        return new Tags($type);
    }

    public function getTags()
    {
        return TagsModel::where('type', TagsTypeConst::TAG)->where('status', WhetherConst::YES)
            ->get();
    }

    /**
     * 过滤敏感词汇
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function sensitive($data)
    {
        $wordFilePath = storage_path('app/words.txt');
        $handle = SensitiveHelper::init()->setTreeByFile($wordFilePath);
        return $handle->replace($data, '***');

    }

    /**
     * 碎片
     * @return Fragment
     */
    public function fragment()
    {
        if(empty($this->fragment)) {
            $this->fragment = new Fragment();
        }
        return $this->fragment;
    }
}