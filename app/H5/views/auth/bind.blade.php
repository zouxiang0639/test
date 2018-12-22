@extends('h5::layouts.master')
@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
    <style>
        .captcha-img {
            cursor: pointer;
            position: absolute;
            right: 1px;
            z-index: 1000;
            height: 32px;
            top: 1px;
        }

    </style>
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">绑定邮箱</div>

                <div class="post-txt">
                    <div class="tab-content" style="padding-top: 20px">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <form method="POST" class="form-horizontal box-body fields-group bind-form" accept-charset="UTF-8" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">
                                        邮箱:
                                    </label>
                                    <div class="col-sm-7 email">
                                        <div class="input-group" style="width:100%">
                                            <input class="form-control" name="email" value="" type="text">
                                            <a class="captcha-img btn btn-info bind-post-verify" >获取邮箱验证码</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group email-verify">
                                    <label for="username" class="col-sm-2 control-label">
                                        邮箱验证码:
                                    </label>
                                    <div class="col-sm-7 email_verify">
                                        <div class="input-group" style="width:100%">

                                            <input name="email_verify" class="form-control col-sm-4" type="text"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a class="btn btn-info col-md-offset-2" id="bind-form-submit">
                                        提交
                                    </a>
                                    <a class="btn btn-info col-md-offset-2" href="{!! route('f.auth.unbound') !!}">
                                        下次再说
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            var locked = true;

            //邮箱验证
            $('.bind-post-verify').click(function() {
                var btn     = $(this);
                $.ajax({
                    type:'post',
                    url:'{!! route('f.auth.email.auth') !!}',
                    data :{
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'email': $(this).siblings('input[name=email]').val(),
                        'type': 2
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

            $('#bind-form-submit').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;
                var _this = $(this);
                var data  = $(".bind-form").serialize();

                _this.attr('disabled',true);
                $('div.text-danger').text('');
                $.ajax({
                    url: '{!! route('f.auth.bind.put') !!}',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code == 1010002){
                            swal({
                                title: "",
                                text: res.data,
                                html: true
                            });
                            _this.attr('disabled',false);
                            locked = true;
                        }else if(res.code != 0){
                            var error = res.data;
                            for ( var i in error ) {
                                $('.'+i).after("<div class='text-danger'>" + error[i][0] + "</div>");
                            }
                            _this.attr('disabled',false);
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = "{!! route('f.auth.login.redirect') !!}";
                        }
                    },
                    error:function () {
                        locked = true;
                        _this.attr('disabled',false);
                    }

                });
                return false;
            });
        })
    </script>
@stop
