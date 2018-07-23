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
    public function Login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect($this->redirectPath());
        }

        return view('admin::auth.login');
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
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            'username' => $this->getFailedLoginMessage(),
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

        return redirect(config('admin.route.prefix'));
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

        return view('admin::auth.setting', [
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
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
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
        admin_toastr(trans('admin.login_successful'));

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

}
