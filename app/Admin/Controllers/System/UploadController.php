<?php

namespace App\Admin\Controllers\System;

use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Admin;

class UploadController extends Controller
{
    public function image(Request $request)
    {

        $file = $request->file($request->name);

        $data = Admin::upload()->uploadOneImage($file);
        return (new JsonResponse())->success($data);
    }

    public function ckeditor(Request $request)
    {
        $file = $request->file('upload');

        $data = Admin::upload()->uploadOneImage($file);
        $data = [
            'uploaded' => 1,
            'fileName' =>$data['url'],
            'url' => $data['url']
        ];
        return json_encode($data);
    }
}
