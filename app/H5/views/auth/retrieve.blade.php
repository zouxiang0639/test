@extends('h5::layouts.master')

@section('content')
    <div class="login-box">
        <form class="retrieve-form" action="" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="form">
                <div><input name="email" type="text" placeholder="邮箱"></div>
                <div class="txt-input login-captcha" style=" margin: 15px 0 0 2px;">
                    <div class="spel">
                        <input name="captcha" style="width: 60%" type="text" placeholder="验证码" />
                        <img src="{{captcha_src()}}" style="cursor: pointer;position: absolute;
width: 32%;margin-top: 0.1rem; margin-left: 10px;height: 1rem;" onclick="this.src='{{captcha_src()}}'+Math.random()" >
                    </div>
                </div>
            </div>

            <div class="btn-login"><a data-action="{!! route('f.auth.retrieve.put') !!}" id="retrieve-submit"   href="javascript:void(0)">找回密码</a></div>
        </form>
    </div>
@stop

@section('script')
    <script>
        $(function() {
            var locked = true;

            //找回密码
            $('#retrieve-submit').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;
                var _this = $(this);
                var data  = $(".retrieve-form").serialize();

                _this.attr('disabled',true);
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
                            $('.close').click();
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