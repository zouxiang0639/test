<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Users\Requests\LoginUserRequest;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * 登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function login()
//    {
//        return view('forum::auth.login');
//    }

    /**
     * 登录数据提交
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function loginPut(LoginUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('forum')->attempt($credentials)) {
            $user = Auth::guard('forum')->user();
            UsersBls::loginPolicy($user);


            return (new JsonResponse())->success('登录成功');
        } else {
            throw new LogicException(1010002, [['邮箱或密码错误']]);
        }
    }

    /**
     * 退出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('forum')->logout();

        $request->session()->invalidate();

        return redirect()->route('f.home');
    }


    /**
     * 注册
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function registerPut(RegisterUserRequest $request)
    {
        if(UsersBls::createUser($request)) {

            $credentials = $request->only(['email', 'password']);
            Auth::guard('forum')->attempt($credentials);

            return (new JsonResponse())->success('注册成功');
        } else {
            throw new LogicException(1010002, [['注册失败']]);
        }

    }

    public function qq()
    {
        return Socialite::with('qq')->redirect();
    }

    public function weibo()
    {
        return Socialite::with('weibo')->redirect();
    }


}
