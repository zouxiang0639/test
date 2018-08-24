<?php

namespace App\Library\Admin\Middleware;

use App\Consts\Admin\Role\RoleSlugConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;

/**
 * Created by Authenticate.
 * @author: zouxiang
 * @date:
 */
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
        $this->auth = Auth::guard('admin');
    }

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param string $permissionCode
     * @return \Illuminate\Http\RedirectResponse
     * @throws LogicException
     */
    public function handle($request, Closure $next, $permissionCode = '')
    {
        //如果是数据库还原就跳出所有权限
        if(config('admin.data_backup_import')) {
            if (in_array(\Request::route()->getName(), ['m.system.backup.import.put', 'm.system.backup.import'])) {
                return $next($request);
            }
        }

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                throw new LogicException(1010004);
            } else {
                return redirect()->route('m.login');
            }
        }

        if($this->auth->user()->is_block == WhetherConst::YES){
            Auth::logout();
            return redirect()->route('m.login');
        }

        if ($permissionCode && !$this->can($this->auth->user(), $permissionCode)) {
            return redirect()->route('m.login');
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

}
