<?php

namespace App\Library\Forum\Middleware;

use App\Consts\Admin\Role\RoleSlugConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     */
    public function __construct()
    {
        $this->auth = Auth::guard('forum');
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $permissionCode
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionCode = '')
    {

        $isMobile = $this->isMobile();




        if ($isMobile) {
           return view('home');//手机端


        } else {
            dd(1);
            return view('pc');//pc端


        }


//        if (!$this->shouldPassThrough($request)){
//
//
//
//
//            if($this->auth->user()->is_block == WhetherConst::YES){
//                Auth::logout();
//                return redirect()->route('m.login');
//            }
//
//            if ($permissionCode && !$this->can($this->auth->user(), $permissionCode)) {
//                return redirect()->route('m.login');
//            }
//        }
        if(!empty($permissionCode)) {
            if ($this->auth->guest()) {
                if ($request->ajax()) {
                    throw new LogicException(1020001);
                } else {
                    return redirect()->route('f.home',['']);
                }
            }
        }

        return $next($request);
    }

    /**
     * 判断该用户是否有该权限点
     * @param $user
     * @param $permission
     * @return bool
     * @author liujian <liujian@piaoshifu.cn>
     */
    protected function can($user, $permission)
    {
        if ( $user->is(RoleSlugConst::ROLE_SUPER) || $user->can($permission) ||  $user->isPermissions($permission)) {
            return true;
        }
        return false;
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $excepts = [
            route('m.login', [], false),
            route('m.logout', [], false),
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
