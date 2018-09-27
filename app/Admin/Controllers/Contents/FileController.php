<?php

namespace App\Admin\Controllers\Contents;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\File\FileBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use View;


class FileController  extends Controller
{

    public function index(Request $request)
    {

        $list = FileBls::getFileLise($request);

        return View::make('admin::contents.file.index', [
            'list' => $list
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = FileBls::find($id);
        $this->isEmpty($model);

        $path = public_path('uploads/'.$model->path);
        if(file_exists($path)) {
            unlink($path);
        }
        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }
}
