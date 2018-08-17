<?php

namespace App\Forum\Controllers;

use App\Forum\Bls\Article\ArticleBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Admin;

class UploadController extends Controller
{
    public function img(Request $request)
    {
        //dd($request->all());

        $file = $request->file($request->name);
        $data['filePath'] = config('config.default_picture');
        $data['url'] = uploads_path(config('config.default_picture'));
        //$data = Admin::upload()->uploadOneImage($file);
        return (new JsonResponse())->success($data);
    }
}
