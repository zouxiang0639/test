<?php

namespace App\Http\Middleware;

use App\Library\Admin\Widgets\Security;
use App\Library\Response\JsonResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Aes解密中间件
 * @author: zouxiang
 * @date:
 */
class ApiAes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $key = '2018082112808102';

        $data = Security::decrypt($request[$guard], $key);

        if($data == false) {
            die((new JsonResponse())->error('1050002'));
        }

        $request->merge(json_decode($data, true));
        return $next($request);
    }
}
