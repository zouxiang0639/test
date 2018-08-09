@extends('canteen::layouts.master')

@section('style')

@stop

@section('content')
    <div id="page-comesoon" class="page">

        <div class="content" id=''>
            <div class="banner bg-login"></div>
            <form action="{:Url('member/login',['url'=>input('url')])}" class="form-horizontal" method="post">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="content-block">
                    <div class="login-box">
                        <dl>
                            <div class="row">
                                <dt class="col-25">用户名</dt>
                                <dd class="col-75">
                                    <input type="tel" maxlength="11" name="mobile" placeholder="请输入您的手机号"></dd>
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
                        <button class="button-orange col-100 login-submit"  type="button">登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
<script>
    $(function() {
        var locked = true;
        $(document).on("click", ".login-submit", function(e) {
            if (! locked) {
                return false;
            }

            locked = false;
            $.ajax({
                url: '{!! route('c.auth.login.put') !!}',
                type: 'POST',
                data: $('.form-horizontal').serialize(),
                dataType: 'json',
                success:function(res) {

                    if(res.code == 1010001) {
                        var error = res.data;
                        var html = '';
                        for ( var i in error ) {
                            html += error[i][0] + "<br>";
                        }
                        $.alert(html);

                    } else if(res.code != 0) {
                        $.alert(res.data);
                    } else {
                        $.alert(res.data);
                        window.location.href = "{!! route('c.member') !!}";
                    }
                    locked = true;
                },
                error:function () {
                    locked = true;
                }

            });

        })
    })
</script>
@stop