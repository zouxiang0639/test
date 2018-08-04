<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Bls\Auth\Requests\settingRequest;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Admin;
use Auth;
use View;

/**
 * Created by AuthController.
 * @author: zouxiang
 * @date:
 */
class AuthController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('m.home');
        }

        return View::make('admin::auth.login');
    }

    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            'username' => '账号或密码错误',
        ]);
    }


    /**
     * 用户退出
     * @param Request $request
     * @return Redirect
     */
    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect()->route('m.login');
    }

    /**
     * User setting page.
     *
     * @return mixed
     */
    public function setting()
    {
        $info = Auth::guard('admin')->user();

        $form = Admin::form(function($item) use ($info) {

            $item->create('用户名', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'username'));
            });

            $item->create('名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('name', array_get($info, 'name'), $h->options);
                $h->set('name', true);
            });

            $item->create('密码', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->password('password', $h->options);
                $h->set('password', true);
            });

            $item->create('确认密码', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->password('password_confirmation', $h->options);
                $h->set('password_confirmation', true);
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });

            $item->create('更新时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'updated_at'));
            });
        })->getFormHtml();

        return View::make('admin::auth.setting', [
            'form' => $form,
            'info' => $info
        ]);

    }


    /**
     * @param settingRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function settingUpdate(settingRequest $request)
    {
        $model = Auth::guard('admin')->user();
        $model->name = $request->name;
        if($request->password) {
            $model->password =  bcrypt($request->password);
        }
        if($model->update()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }

    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        admin_toastr('登录成功');
        $request->session()->regenerate();

        return redirect()->route('m.home');
    }

}
