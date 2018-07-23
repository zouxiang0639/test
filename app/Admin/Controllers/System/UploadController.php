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
}
