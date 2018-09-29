@extends('admin::layouts.master')

@section('content-header')
    <h1>
        用户<small>列表</small>
    </h1>
@stop
@section('content')

    <div class="box">
        <div class="box-header">

            <div class="pull-right">
            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>昵称</th>
                    <th>邮箱</th>
                    <th>禁言时间</th>
                    <th>更新时间</th>
                    <th>状态 (yes:禁止登录)</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{!! $item->name !!}</td>
                        <td>{!! $item->email !!}</td>

                        <td>{!! $item->excuse_time !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td class="switch_submit" data-href="{!! route('m.customer.users.status', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->status) !!}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{!! route('m.customer.users.edit', ['id' => $item->id]) !!}" type="button" class="btn btn-info">详情</a>
                                <button type="button" class="btn btn-info excuse" data-toggle="modal" data-target="#modal-excuse"
                                        data-url="{!! route('m.customer.users.excuse', ['id' => $item->id]) !!}"
                                        data-date="{!! $item->excuse_time !!}">禁言</button>
                            </div>

                        </td>
                    </tr>
                @endforeach

            </table>
        </div>

        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->
    </div>
    <div class="modal fade" id="modal-excuse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">禁言时间</h4>
                </div>
                <div class="modal-body">
                    {!! Form::datetime('date', '', ['class'=>'form-control'], 'YYYY-MM-DD') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary excuse_submit">提交</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop

@section('script')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
    <script>
        $(function() {
            var locked = true;
            var excuseDataUrl = '';
            $('.excuse').click(function() {
                excuseDataUrl = $(this).attr('data-url');
                var date = $(this).attr('data-date');
                $('input[name=date]').val(date);
            });

            /**
             *  禁言
             */
            $(".excuse_submit").click(function(){

                if (! locked) {
                    return false;
                }
                locked = false;

                $.ajax({
                    url: excuseDataUrl,
                    type: 'POST',
                    data: {
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "date": $('input[name=date]').val()
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = document.location;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });
            })
        })
    </script>
@stop