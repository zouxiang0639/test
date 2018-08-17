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

}

