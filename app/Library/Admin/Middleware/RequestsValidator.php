<?php

namespace App\Library\Admin\Middleware;

use Closure;
use Validator;
use Input;

class RequestsValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return preg_match('/^1[0-9]{10}$/', $value);
        });
        return $next($request);
    }
}
