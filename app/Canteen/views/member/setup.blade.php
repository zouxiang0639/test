@extends('canteen::layouts.master')

@section('content')


    <div id="user-setting" class="page">
        <header class="bar bar-nav">
            <span class="icon-setting white"></span><h1 class="page-title">账户设置</h1>
        </header>
        <div class="bar footer-nav">
            <a class="footer-nav-back back" href="index.html"></a>
        </div>
        <div class="content" id=''>
            <form action="" method="post" class="form-horizontal">
                <div class="content" id=''>
                    <form method='post' class="form-horizontal">
                        <input name="_method" type="hidden" value="PUT">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="list-block">
                            <ul>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title label">原密码</div>
                                            <div class="item-input">
                                                <input type="password" name="old_password" placeholder="原密码" value=''>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title label">新密码</div>
                                            <div class="item-input"><input name="password" type="password" placeholder="新密码" value=''></div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title label">确认新密码</div>
                                            <div class="item-input"><input name="password_confirmation" type="password" placeholder="确认新密码" value=''></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="content-block">
                            <button type="button" class="button-orange setup-post">确认修改</button>
                        </div>
                    </form>
                </div>
            </form>
        </div>

    </div>
@stop

@section('script')
    <script>
        $(function() {
            var locked = true;

            $('.setup-post').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('c.member.setting.password') !!}',
                    type: 'POST',
                    data: $('.form-horizontal').serialize(),
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {

                            var errorHtml = '';
                            var error = res.data;
                            for ( var i in error ) {
                                errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                            }
                            $.alert(errorHtml);
                            locked = true;
                        } else {
                            $.alert(res.data);
                            window.location.href = '{!! route('c.member') !!}';
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });

            })
        })
    </script>
@stop