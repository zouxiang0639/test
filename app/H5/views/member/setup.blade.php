@extends('h5::layouts.master')

@section('style')
    <script src="{{  assets_path("/forum/js/jQuery-2.1.4.min.js") }}"></script>
    <script src="{{  assets_path("/lib/bootstrap3/bootstrap.min.js") }}"></script>
@stop

@section('content')
    @include("h5::partials.member_info")

    <div class="pages" style="margin-top: 0.2rem">
        <div class="post-con">

            <ul class="nav nav-tabs" style="background: #ffffff;" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">基本信息</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">修改密码</a></li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="padding: 0.2rem 0.1rem;">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <form method="POST" class="form-horizontal box-body fields-group" accept-charset="UTF-8" >
                        <input name="_token" value="{!! csrf_token() !!}" type="hidden">
                        <input name="_method" value="PUT" type="hidden">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                昵称:
                            </label>
                            <div class="col-sm-7 name">
                                <div class="input-group" style="width:100%">
                                    <input class="form-control" name="name" value="{!! $info->name !!}" type="text">
                                </div>
                                    <span class="help-block">
                <i class="fa fa-info-circle"></i>&nbsp;（修改昵称需要扣50个积分）
            </span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-info col-md-offset-2 form-submit" data-url="{!! route('f.member.setup.basic') !!}">
                                提交
                            </a>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">

                    <form method="POST" accept-charset="UTF-8" class="form-horizontal box-body fields-group">
                        <input name="_token" value="{!! csrf_token() !!}" type="hidden">
                        <input name="_method" value="PUT" type="hidden">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                <span class="text-danger">*</span>
                                原始密码:
                            </label>
                            <div class="col-sm-7 old_password">
                                <div class="input-group" style="width:100%">
                                    <input class="form-control" name="old_password" value="" type="password">

                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">

                                <span class="text-danger">*</span>
                                密码:
                            </label>
                            <div class="col-sm-7 password">
                                <div class="input-group" style="width:100%">
                                    <input class="form-control" name="password" value="" type="password">

                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">

                                <span class="text-danger">*</span>
                                确认密码:
                            </label>
                            <div class="col-sm-7 password_confirmation">
                                <div class="input-group" style="width:100%">
                                    <input class="form-control" name="password_confirmation" value="" type="password">

                                </div>

                            </div>
                        </div>

                        <div class="box-footer">
                            <a class="btn btn-info col-md-offset-2 form-submit" data-url="{!! route('f.member.setup.password') !!}">
                                提交
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(function() {
            var locked = true;
            /**
             *  表单ajax提交
             */
            $('.form-submit').click(function() {

                if (! locked) {
                    return false;
                }

                locked = false;
                var _this = $(this);
                var data  = $(this).parents(".form-horizontal").serialize();

                _this.attr('disabled',true);
                $('div.text-danger').text('');
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code == 1010001) {
                            var error = res.data;
                            for ( var i in error ) {
                                $('.'+i).after("<div class='text-danger'>" + error[i][0] + "</div>");
                            }
                            _this.attr('disabled',false);
                            locked = true;
                        } else if(res.code != 0){
                            swal(res.data, '', 'error');
                            _this.attr('disabled',false);
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');

                            setTimeout("window.location.href = '{!! route("f.member.index") !!}'; ",2000);
                        }
                    },
                    error:function () {
                        _this.attr('disabled',false);
                        locked = true;
                    }

                });
                return false;
            });
        })
    </script>
@stop