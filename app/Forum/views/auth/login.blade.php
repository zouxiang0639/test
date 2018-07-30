<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/login.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
    <link rel="stylesheet" href="{{  assets_path("/lib/sweetalert/dist/sweetalert.css") }}">
    <script src="{{  assets_path("/forum/js/jQuery-2.1.4.min.js") }}"></script>
</head>
<body>
<div class="fixed">
    <div class="com-box">
        <div class="top">
            <h3 class="tit">登录</h3>
            <a class="close" href="javascript:void(0)"></a>
        </div>
        <div class="center">
            <div class="txt-input">
                <form class="login-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                <div class="spel"><input name="email" type="text" placeholder="邮箱" /></div>
                <div class="spel"><input name="password" type="password" placeholder="密码" /></div>
                </form>
            </div>
            <div class="txt-opt clearfix">
                <p class="lt fl">
                    <a href="javascript:void(0)">注册</a>/
                    <a href="javascript:void(0)">忘记密码</a>
                </p>
                <p class="rt fr">
                    <input type="checkbox" id="check1" value="123" name="name" class="check"><label for="check1">自动登录</label>
                </p>
            </div>
            <div class="dl-con">
                <a class="login-btn" id="form-submit" href="javascript:void(0)">登录</a>
            </div>
            <div class="other-dl">
                其他登录<a class="qq" href="javascript:void(0)"></a>
                <a class="wb" href="javascript:void(0)"></a>
            </div>
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
            var data  = $(".login-form").serialize();

            _this.attr('disabled',true);
            $('div.text-danger').text('');
            $.ajax({
                url: '{!! route('f.auth.login.put') !!}',
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
                        window.location.href = "{!! route('f.member.index') !!}";
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
