<?php

namespace App\Http\Controllers;

use App\Exceptions\LogicException;
use App\Library\Response\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function error($code = '', $message = ''){
        return (new JsonResponse())->error($code, $message, '', false);
    }

    public function success($data = []){
        return (new JsonResponse())->success($data);
    }
}
