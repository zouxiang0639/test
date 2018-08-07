@extends('canteen::layouts.master')

@section('style')

@stop

@section('content')
    <div class="page-group">
        <div id="page-comesoon" class="page">
            <div class="bar footer-nav">
                <a class="footer-nav-back back" href="index.html"></a>
            </div>
            <div class="content" id=''>
                <div class="banner bg-login"></div>
                <form action="{:Url('member/login',['url'=>input('url')])}" class="form-horizontal" method="post">

                    <div class="content-block">
                        <div class="login-box">
                            <dl>
                                <div class="row">
                                    <dt class="col-25">用户名</dt>
                                    <dd class="col-75">
                                        <input type="tel" maxlength="11" name="username" placeholder="请输入您的手机号"></dd>
                                </div>
                            </dl>
                            <dl>
                                <div class="row">
                                    <dt class="col-25">密  码</dt>
                                    <dd class="col-75"><input type="password" name="password" placeholder="请输入您的登录密码"></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="content-block">
                        <div class="row">
                            <button class="button-orange col-100 ajax-post"  type="button">登录</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop