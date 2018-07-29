<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/login.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
    <link rel="stylesheet" href="{{  assets_path("/lib/sweetalert/dist/sweetalert.css") }}">
    <script src="{{  assets_path("/forum/js/jQuery-2.1.4.min.js") }}"></script>
</head>
<body>
<div class="fixed">
    <div class="com-box">
        <div class="top">
            <h3 class="tit">注册</h3>
            <a class="close" href="javascript:void(0)"></a>
        </div>
        <div class="center">
            <form class="register-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">
                <div class="txt-input">
                    <div class="spel"><input name="email" type="text" placeholder="邮箱" /></div>
                    <div class="spel"><input name="name" type="text" placeholder="昵称" />
                        {{--<a class="jc" href="javascript:void(0)">重复检测</a>--}}
                    </div>
                    <div class="spel"><input name="password" type="password" placeholder="密码" /></div>
                    <div class="spel"><input name="password_confirmation" type="password" placeholder="确认密码" /></div>
                </div>
                <div class="agree">
                    <p class="ck"><input type="checkbox" id="check1" value="123" name="is_read" class="check"><label for="check1">我已阅读并同意</label></p>
                    <a class="agree-link" href="javascript:void(0)">空地社区用户注册协议</a>
                </div>

                <div class="res-con">
                    <a class="register-btn" id="form-submit" href="javascript:void(0)">注册</a>
                    <a class="login-link" href="javascript:void(0)">已有账号登录</a>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="{{  assets_path("/lib/sweetalert/dist/sweetalert.min.js") }}"></script>
<script>
    $(function(){
        var locked = true;
        $('#form-submit').click(function() {
            if (! locked) {
                return false;
            }

            locked = false;
            var _this = $(this);
            var data  = $(".register-form").serialize();

            _this.attr('disabled',true);
            $('div.text-danger').text('');
            $.ajax({
                url: '{!! route('f.auth.register.put') !!}',
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
                        window.location.href = config.backUrl;
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
</body>
</html>
