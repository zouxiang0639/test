@extends('canteen::layouts.master')

@section('style')
    <style>
        .icon-avatar {
            color: #4495F0;
            width: 2rem;
            height: 2rem;
            line-height: 2rem;
            border-radius: 50%;
            text-align: center;
            background: #ffffff;
            font-size: 2.5rem;
            padding: 0.4rem;
        }
    </style>
@stop

@section('content')

    <div class="page-group">
        <div class="page" id="page-index" >

            @include('canteen::partials.footer')
            <div class="content" id='page-product'>
                <!--user center-->
                <div class="user-head">
                    <a href="#"><i class="fa fa-credit-card"></i><br/>付款二维码</a>
                    <div>
                        <span class="icon-avatar"> <i class="fa fa-user"></i></span>
                    </div>
                    <dl>
                        <dt>张三</dt>
                        <dd>13816720691</dd></dl>
                </div>

                <div class="row no-gutter user-account-info"  >
                    <div class="col-100" style="text-align: center">
                        <strong style="font-size: 1rem;">余额</strong>
                        <p>￥50.00</p>
                    </div>
                </div>

                <div class="user-list">
                    <ul>
                        <li>
                            <a href="{:Url('member/account')}">
                                <span class="icon-account"></span>账户明细</a>
                        </li>
                        <li>
                            <a href="{:Url('order/index')}">
                                <span class="icon-bought"></span>订单管理</a>
                        </li>
                        <li>
                            <a href="{:Url('userSetting/index')}">
                                <small>密码修改</small>
                                <span class="icon-setting"></span>账户设置</a>
                        </li>
                        <li>
                            <a href="{:Url('member/logout')}">
                                <!--<small>实名认证、密码修改、银行卡绑定</small>-->
                                <span class="icon-about white"></span>安全退出</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop