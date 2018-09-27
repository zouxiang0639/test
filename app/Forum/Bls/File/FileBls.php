<?php

namespace App\Forum\Bls\File;

use App\Forum\Bls\File\Model\FileModel;
use Auth;

/**
 * Class FileBls.
 */
class FileBls
{
    public static function createFile($filePath, $type)
    {
        $model = new FileModel();
        $model->type = $type;
        $model->path = $filePath;
        $model->user_id = Auth::guard('forum')->id();
        return $model->save();

    }

    /**
     * 文章列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFileLise($request, $order = '`id` DESC', $limit = 30)
    {
        $model = FileModel::query();

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function find($id)
    {
        return FileModel::find($id);
    }

}

