@extends('h5::layouts.master')

@section('content')

    <div class="login-box">
        <div class="tab">
            <a class="login" href="{!! route('h.auth.login') !!}">登录</a>
            <a class="on" href="javascript:void(0)">注册</a>
        </div>
        <form class="register-form"  autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="form">
                <div class="clearfix">
                    <input class="email" name="email" type="text" placeholder="邮箱" />
                </div>
                <div class="clearfix">
                    <div class="email-verify" style="display: none">
                        <input name="email_verify" class="email"  type="text" placeholder="邮箱验证码" />
                     </div>
                    <a class="yzm post-verify" href="javascript:;">获取验证码</a>
                </div>
                <div class="clearfix">
                    <input class="name" name="name" type="text" placeholder="昵称" />
                    <a class="jz check-name" href="javascript:;">重复检测</a>
                </div>
                <div><input name="password" class="pass" type="password" placeholder="密码" /></div>
                <div><input name="password_confirmation" class="pass" type="password" placeholder="确认密码" /></div>
            </div>
            <div class="opt">
                <p>
                    <span class="read">
                        <input type="checkbox" id="check1" value="123" name="is_read" class="check" style="margin: -2px 5px 0 0;">我已阅读并同意
                    </span>
                    <a href="{!! route('h.auth.info') !!}">空地社区用户注册协议</a>
                </p>
            </div>
            <div class="btn-register"><a data-action="{!! route('f.auth.register.put') !!}" id="register-submit" href="javascript:;">注册</a></div>
        </form>
    </div>
@stop

@section('script')
    <script>
        $(function() {
            var locked = true;
            $('#register-submit').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;
                var _this = $(this);
                var data  = $(".register-form").serialize();

                _this.attr('disabled',true);
                $('div.text-danger').text('');
                $.ajax({
                    url: _this.attr('data-action'),
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0){
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
                        _this.attr('disabled',false);
                    }

                });
                return false;
            });

            //邮箱验证
            $('.post-verify').click(function() {
                var btn     = $(this);
                $.ajax({
                    type:'post',
                    url:'{!! route('f.auth.email.auth') !!}',
                    data :{
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'email': $('.register-form input[name=email]').val()
                    } ,
                    dataType:  'json',
                    success: function(json) {
                        if(json.code != 0){
                            var errorHtml = '';
                            var error = json.data;
                            for ( var i in error ) {
                                errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                            }
                            swal({
                                title: "",
                                text: errorHtml,
                                html: true
                            });
                            btn.removeAttr("style");
                        }else{
                            var  b = 60;
                            var	a = setInterval(function() {
                                if( 0 <= b){
                                    btn.html(b + "秒后重发");
                                }else{
                                    btn.html("获取验证码");
                                    btn.removeAttr("style");
                                    clearInterval(a);
                                }
                                return b--;
                            },1e3);
                            swal({
                                title: "邮件发送成功！",
                                text: "2秒后自动关闭",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('.email-verify').show();
                        }
                    },
                    error:function(xhr){
                        btn.removeAttr("style");
                    },
                    beforeSend:function(){
                        btn.css({'pointer-events': 'none','background-color':'#b4b1ae'});
                    }
                });
            });

            $('.check-name').click(function() {
                $.ajax({
                    type:'post',
                    url:'{!! route('f.auth.check.name') !!}',
                    data :{
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'name':$('.register-form input[name=name]').val()
                    } ,
                    dataType:  'json',
                    success: function(json) {
                        if(json.code != 0){
                            var errorHtml = '';
                            var error = json.data;
                            for ( var i in error ) {
                                errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                            }
                            swal({
                                title: "",
                                text: errorHtml,
                                html: true
                            });
                        }else{
                            swal({
                                title: "",
                                text: "<p class='text-danger'>" + json.data + "</p>",
                                html: true
                            });
                        }
                    }
                });
            })
            });


    </script>
@stop