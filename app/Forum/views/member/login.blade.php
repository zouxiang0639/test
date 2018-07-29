<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/login.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
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
                <div class="spel"><input type="text" placeholder="ID" /></div>
                <div class="spel"><input type="password" placeholder="PASSWOR" /></div>
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
                <a class="login-btn" href="javascript:void(0)">登录</a>
            </div>
            <div class="other-dl">
                其他登录<a class="qq" href="javascript:void(0)"></a>
                <a class="wb" href="javascript:void(0)"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
