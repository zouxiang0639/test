@extends('h5::layouts.master')

@section('content')
    <div class="login-box">
        <div class="tab">
            <a class="login on" href="javascript:void(0)">登录</a>
            <a href="{!! route('h.auth.register') !!}">注册</a>
        </div>
        <form class="login-form" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="form">
                <div><input class="txt" name="email" type="text" placeholder="邮箱" /></div>
                <div><input class="pass" name="password" type="password" placeholder="密码" /></div>
                <div class="txt-input login-captcha" style="@if(intval(Session::get('login_num')) <   5) display: none; @endif margin: 15px 0 0 2px;">
                    <div class="spel">
                        <input name="captcha" style="width: 60%" type="text" placeholder="验证码" />
                        <img src="{{captcha_src()}}" style="cursor: pointer;position: absolute;
width: 32%;margin-top: 0.1rem; margin-left: 10px;height: 1rem;" onclick="this.src='{{captcha_src()}}'+Math.random()" >
                    </div>
                </div>
            </div>
            <div class="opt">
                <a class="forget" href="{!! route('h.auth.retrieve') !!}">忘记密码</a>

                <a style="float: right"  class="zd-login" href="javascript:void(0)">自动登录</a>
                <input name="is_automatic_login" value="1" type="checkbox" placeholder="密码" style="float: right;    margin-top: 2px;" />
            </div>
            <div class="btn-login"><a data-action="{!! route('f.auth.login.put') !!}" id="login-submit"  href="javascript:void(0)">登录</a></div>
        </form>
    </div>
@stop

@section('script')
<script>
    $(function() {
        var locked = true;
        $('#login-submit').click(function() {
            if (! locked) {
                return false;
            }

            locked = false;
            var _this = $(this);
            var data  = $(".login-form").serialize();

            _this.attr('disabled',true);
            $('div.text-danger').text('');
            $.ajax({
                url: _this.attr('data-action'),
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                success:function(res) {
                    if(res.code == 1020002) {
                        swal({
                            title: "",
                            text: "<p class='text-danger'>" + res.data + "</p>",
                            html: true
                        });
                    } else if(res.code != 0){
                        var errorHtml = '';
                        var error = res.data;
                        for ( var i in error ) {
                            errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                        }
                        swal({
                            title: "",
                            text: errorHtml,
                            html: true
                        });
                        _this.attr('disabled',false);
                        locked = true;
                    } else {

                        swal(res.data, '', 'success');
                        setTimeout("window.location.href =  '{!! route("h.member.index") !!}'; ",2000);
                    }
                },
                error:function () {
                    locked = true;
                }

            });
            return false;
        });

    })
</script>
@stop