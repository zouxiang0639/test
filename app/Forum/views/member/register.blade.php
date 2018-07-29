<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/login.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />

</head>
<body>
<div class="fixed">
    <div class="com-box">
        <div class="top">
            <h3 class="tit">注册</h3>
            <a class="close" href="javascript:void(0)"></a>
        </div>
        <div class="center">
            <div class="txt-input">
                <div class="spel"><input type="text" placeholder="邮箱" /></div>
                <div class="spel"><input type="text" placeholder="昵称" /><a class="jc" href="javascript:void(0)">重复检测</a></div>
                <div class="spel"><input type="password" placeholder="密码" /></div>
                <div class="spel"><input type="password" placeholder="确认密码" /></div>
            </div>
            <div class="agree">
                <p class="ck"><input type="checkbox" id="check1" value="123" name="name" class="check"><label for="check1">我已阅读并同意</label></p>
                <a class="agree-link" href="javascript:void(0)">空地社区用户注册协议</a>
            </div>

            <div class="res-con">
                <a class="register-btn" href="javascript:void(0)">注册</a>
                <a class="login-link" href="javascript:void(0)">已有账号登录</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
