@extends('admin::layouts.master')

@section('content-header')
    <h1>
        配置<small>设置</small>
    </h1>
@stop
@section('content')

    <div class="box">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">网址配置</a></li>
                <li><a href="#forum" data-toggle="tab">论坛设置</a></li>
                <li><a href="#timeline" data-toggle="tab">敏感词汇设置</a></li>
                {{--<li><a href="#activity" data-toggle="tab">activity</a></li>--}}
                <li class="btn-primary" style="float: right;"><a style="color: white" href="{!! route('m.system.config.list') !!}" >配置列表</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    {!! $form !!}
                </div>
                <div class="active tab-pane" id="forum">
                    {!! $forum !!}
                </div>
                <div class="tab-pane" id="timeline">
                    <form method="POST" action="http://localhost/web/forum/public/admin/system/config/set" accept-charset="UTF-8" class="form-horizontal box-body fields-group">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                敏感词汇设置:
                            </label>
                            <div class="col-sm-7 description">
                                <div class="input-group" style="width:100%">
                                    <textarea class="form-control" name="words" cols="50" rows="20"> {!! $words !!}</textarea>

                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <a data-url="{!! route('m.system.config.sensitive') !!}" class="btn btn-info col-md-offset-2 set-submit">
                                提交
                            </a>
                        </div>
                    </form>

                </div>

                <div class="tab-pane" id="activity">
                </div>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.system.config.set.post') !!}",
            "backUrl":"{!! route('m.system.config.set') !!}"
        };

        $(function(){
            var locked = true;
            $('.set-submit').click(function(){

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
                        if(res.code != 0){
                            swal(res.data, '', 'error');
                        } else {
                            swal(res.data, '', 'success');
                        }
                        _this.attr('disabled',false);
                        locked = true;
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