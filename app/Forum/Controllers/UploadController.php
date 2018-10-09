<?php

namespace App\Forum\Controllers;

use App\Consts\Common\FileTypeConst;
use App\Forum\Bls\File\FileBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Admin;

class UploadController extends Controller
{
    public function img(Request $request)
    {
        $file = $request->file('file');

        $data = Admin::upload()->uploadOneImage($file);

        FileBls::createFile($data['filePath'], FileTypeConst::IMG);
        return (new JsonResponse())->success($data);
    }

    public function ckeditorImg(Request $request)
    {
        $file = $request->file('upload');

        $data = Admin::upload()->uploadOneImage($file);
        $data = [
            'uploaded' => 1,
            'fileName' =>$data['url'],
            'url' => $data['url']
        ];
        FileBls::createFile($data['filePath'], FileTypeConst::IMG);
        return json_encode($data);
    }
}
