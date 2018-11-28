<?php

namespace App\H5\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Users\Requests\LoginUserRequest;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mail;
use Illuminate\Support\Facades\Validator;
use Session;

class AuthController extends Controller
{
    /**
     * 登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        if (Auth::guard('forum')->check()) {
            return redirect()->route('h.member.index');
        }

        return view('h5::auth.login');
    }


    public function register()
    {
        if (Auth::guard('forum')->check()) {
            return redirect()->route('h.member.index');
        }

        return view('h5::auth.register');
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

        return redirect()->route('h.home');
    }

    public function qq()
    {
        return Socialite::with('qq')->redirect();
    }

    public function weibo()
    {
        return Socialite::with('weibo')->redirect();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function emailAuth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已被注册',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010002, $validator->getMessageBag());
        }

        try {
            $emailAuth = rand(111111, 999999);

            $content = '验证码:' . $emailAuth . ',半个小时后失效';
            Mail::send('forum::email.content', ['content' => $content], function ($m) use ($request) {
                $m->from(config("mail.from.address"), config("mail.from.name"));
                $m->to($request->email);
                $m->subject('验证码');
            });

            Session::put('email_auth', $emailAuth);
            Session::put('email_auth_time', time() + 1800);
            Session::put('email', $request->email);
            //创建备份文件
            Session::save();
            return (new JsonResponse())->success('发送成功');
        } catch (\Exception $e) {
            throw new LogicException(1010002, [['发送失败']]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function checkName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10|sensitive|unique:users,name',
        ], [
            'name.required' => '昵称不能为空',
            'name.unique' => '昵称已被注册',
            'name.max' => '昵称字数超出',
            'name.sensitive' => '昵称不能有敏感词汇',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010002, $validator->getMessageBag());
        }


        return (new JsonResponse())->success('昵称可以使用');
    }


    public function info()
    {
        $info = config('config.protocol');
        return view('h5::auth.info', [
            'info' => $info
        ]);

    }

    /**
     * 找回密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function retrieve()
    {


        return view('h5::auth.retrieve', [
        ]);

    }
}
