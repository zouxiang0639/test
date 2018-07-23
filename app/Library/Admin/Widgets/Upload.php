<?php

namespace App\Library\Admin\Widgets;

use Illuminate\Http\UploadedFile;
use Storage;

/**
 * Class Upload.
 */
class Upload
{
    const IMAGE = 'image';

    public function uploadOneImage(UploadedFile $file)
    {
        return self::upload($file, self::IMAGE);
    }

    private function upload(UploadedFile $file, $type)
    {
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();

        $filePath = self::getPath($type, $name, $ext);

        Storage::disk('admin')->put($filePath,file_get_contents($file->getRealPath()));

        $data['filePath'] = $filePath;
        $data['url'] = Storage::disk('admin')->url($filePath);
        return $data;
    }

    private function getPath($type, $name, $ext)
    {

        $fileName = md5(uniqid($name));

        return $type . '/' . date('Ym') . '/' . date('d') . '/' . $fileName . '.' . $ext; //生成新的的文件名

    }

}