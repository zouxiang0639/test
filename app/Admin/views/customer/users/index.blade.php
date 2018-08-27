@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        用户<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        {!! Form::select('division', $division,
                        Input::get('mobile'), ['class' => 'form-control', 'placeholder'=>'全部']) !!}
                    </div>
                    <div class="input-group input-group-sm">
                        <input name="name" value="{!! Input::get('name') !!}" type="text" class="form-control" placeholder="姓名">
                    </div>
                    <div class="input-group input-group-sm " style="width: 150px;">
                        <input name="mobile" value="{!! Input::get('mobile') !!}" class="form-control pull-right" placeholder="手机号" type="text">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>



        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>分组</th>
                    <th>余额</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>

                        <td>{{ $item->name }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->divisionNmae }}</td>
                        <td>{{ $item->formatMoney }}</td>

                        <td class="switch_submit" data-href="{!! route('m.customer.users.status', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->status) !!}
                        </td>
                        <td>
                            <div class="btn-group">
                            <a class="btn btn-default" href="{!! route('m.customer.users.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                                <button class="btn btn-default reset" data-href="{!! route('m.customer.users.reset', ['id' => $item->id]) !!}">初始化密码</button>
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

@stop

@section('script')
<script>
    $(function() {
        var locked = true;
        $('.reset').click(function() {
            var _this = $(this);

            swal({
                        title: '你确定初始化密码吗?密码将会是{!! config('admin.user_password') !!}',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确定",
                        closeOnConfirm: false,
                        cancelButtonText: "取消"
                    },
                    function(){

                        if (! locked) {
                            return false;
                        }

                        locked = false;
                        $.ajax({
                            url: _this.attr('data-href'),
                            type: 'POST',
                            data: {
                                "_method":"PUT",
                                "_token":$('meta[name="csrf-token"]').attr('content')
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

                    }
            );
        })
    })
</script>
@stop