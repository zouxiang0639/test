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

            Session::put('login_num', 0);
            Session::save();

            return (new JsonResponse())->success('登录成功');

        } else {
            $loginNum = intval(Session::get('login_num'));
            Session::put('login_num', $loginNum+1);
            Session::save();

            if($loginNum >= 5) {
                throw new LogicException(1020002, '邮箱或密码错误');
            }
            throw new LogicException(1010002, [['邮箱或密码错误'],[$loginNum]]);
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

    public function retrievePut(Request $request)
    {
        $model = UsersBls::getUserByEmail($request->email);

        Validator::extend('emailIsNull', function ($attribute, $value, $parameters) use($model) {
            return !is_null($model);
        });

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|email_is_null',
            'captcha' => 'required|captcha',
        ],[
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.email_is_null' => '请检查是否邮箱输入错误',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码错误'
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010002, $validator->getMessageBag());
        }


        $model->remember_token = Str::random(60);
        $model->save();

        try{
            $route = route('f.auth.retrieve', ['token'=>$model->remember_token]);
            $content = <<<EOT
您好，{$model->name} ： <br>

请点击下面的链接来重置您的密码。<br>

<a href="{$route}">{$route}</a><br>

如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>

该验证邮件有效期为30分钟，超时请重新发送邮件。
EOT;

            Mail::send('forum::email.content', ['content' => $content], function ($m)  use ($request) {
                $m->from(config("mail.from.address"), config("mail.from.name"));
                $m->to($request->email);
                $m->subject('密码找回');
            });

            Session::put('retrieve_password_time', time() + 1800);
            Session::put('retrieve_password_email', $request->email);
            //创建备份文件
            Session::save();
            return (new JsonResponse())->success("重置密码邮件已经发送到{$request->email} ，请登录邮箱重置！");
        }catch (\Exception $e){
            throw new LogicException(1010002, [['发送失败']]);
        }
    }

    public function retrieve($token)
    {
        $model = UsersBls::getUserByToken($token);

        $this->isEmpty($model);

        if(Session::get('retrieve_password_email') != $model->email && Session::get('retrieve_password_time') < time()) {
            throw new LogicException(1010001);
        }

        return view('forum::auth.retrieve', [
            'info' => $model
        ]);
    }

    public function retrieveUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|max:255',
        ],[
            'password.required' => '新密码不能为空',
            'password.confirmed' => '两次密码输入不一致',
        ]);

        $model = UsersBls::getUserByToken($request->token);

        $this->isEmpty($model);

        if(Session::get('retrieve_password_email') != $model->email && Session::get('retrieve_password_time') < time()) {
            throw new LogicException(1010001);
        }


        if ($validator->fails()) {
            throw new LogicException(1010001, $validator->getMessageBag());
        }

        $model->password = bcrypt($request->password);

        if($model->save()) {

            Session::put('retrieve_password_time', 0);
            Session::put('retrieve_password_email', null);
            //创建备份文件
            Session::save();

            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, [['操作失败']]);
        }


    }
}
