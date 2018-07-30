<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" style="width: 420px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close blue" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title blue">注册</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="register-form" action="">
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
                        <div class=" res-con">

                            <button data-action="{!! route('f.auth.register.put') !!}" id="register-submit" type="button" style="background: #219d98; color: beige;width: 122px;" class="btn">注册</button>
                            <a class="login-link" href="javascript:void(0)">已有账号登录</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" style="width: 420px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close blue" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title blue">登录</h4>
            </div>
            <div class="modal-body">
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
                        <button data-action="{!! route('f.auth.login.put') !!}" id="login-submit" type="button" style="background: #219d98; color: beige;width: 122px;" class="btn">登录</button>

                    </div>
                    <div class="other-dl">
                        其他登录<a class="qq" href="javascript:void(0)"></a>
                        <a class="wb" href="javascript:void(0)"></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function(){
        var locked = true;

</script>
