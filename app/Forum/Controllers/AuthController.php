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
use Mail;
use Illuminate\Support\Facades\Validator;
use Session;

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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function emailAuth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ],[
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已被注册',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010002, $validator->getMessageBag());
        }

        try{
            $emailAuth = rand(111111,999999);

            $content = '验证码:' . $emailAuth . ',半个小时后失效';
            Mail::send('forum::email.content', ['content' => $content], function ($m)  use ($request) {
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
        }catch (\Exception $e){
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
            'name' => 'required|unique:users,name',
        ],[
            'name.required' => '昵称不能为空',
            'name.unique' => '昵称已被注册',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010002, $validator->getMessageBag());
        }


        return (new JsonResponse())->success('昵称可以使用');
    }


    public function info()
    {
        $info = config('config.protocol');
        return view('forum::auth.info', [
            'info' => $info
        ]);

    }
}
