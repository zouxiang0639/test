@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
    <style>
        .clearfix label{
            width: 100px;
            text-align: right;
        }
    </style>
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">找回密码</div>
                <form class="retrieve-password-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="post-txt" style="font-size: 19px">
                        <div class="tep2 clearfix">
                            <p class="sel">
                                <label>用户名:</label>
                                {!! $info->name !!}
                            </p>
                            <p class="sel">
                                <label>邮箱:</label>
                                {!! $info->email !!}
                                <input type="hidden" name="token" value="{!!  $info->remember_token !!}">
                            </p>
                            <p class="sel">
                                <label>新密码:</label>
                                <span><input name="password" style="width: 200px;" type="text" placeholder="请填写标题" /></span>
                            </p>
                            <p class="sel">
                                <label>确认密码:</label>
                                <span><input name="password_confirmation" style="width: 200px;" type="text" placeholder="请填写标题" /></span>
                            </p>
                            <p class="sel">
                                <label></label>
                                <a class="btn btn-default" id="retrieve-password-submit" data-action="{!! route('f.auth.retrieve.update') !!}" href="javascript:void(0)">提交</a>
                            </p>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script>


        $(function() {

            var locked = true;

            //注册
            $('#retrieve-password-submit').click(function () {

                if (!locked) {
                    return false;
                }

                locked = false;
                var _this = $(this);
                var data = $(".retrieve-password-form").serialize();

                _this.attr('disabled', true);
                $('div.text-danger').text('');
                $.ajax({
                    url: _this.attr('data-action'),
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function (res) {
                         if (res.code != 0) {
                            var errorHtml = '';
                            var error = res.data;
                            for (var i in error) {
                                errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                            }
                            swal({
                                title: "",
                                text: errorHtml,
                                html: true
                            });
                            _this.attr('disabled', false);
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = '{!! route('f.home') !!}';
                        }
                    },
                    error: function () {
                        locked = true;
                        _this.attr('disabled', false);
                    }

                });
                return false;
            });
        });
    </script>
    @stop