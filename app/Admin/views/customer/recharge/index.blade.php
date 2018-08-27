@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        充值<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline" name="search" action="">
                    <div class="input-group input-group-sm" style="min-width: 100px">
                        {!! Form::select2('user_id', $usersList,
                        Input::get('user_id'), ['class' => 'form-control', 'placeholder'=>'全部用户']) !!}
                    </div>
                    <div class="input-group input-group-sm" >
                        {!! Form::datetimeRange(['name' =>'start_time', 'value' => ''], ['name' =>'end_time', 'value' => ''] ,['class' => 'form-control', 'placeholder'=>'时间筛选'], 'YYYY-MM-DD')!!}
                        <div class="input-group-btn">
                            <button id="flow-search"  type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="pull-right">
                <a href="{!! route('m.customer.recharge.money') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;充值
                </a>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>用户</th>
                    <th>类型</th>
                    <th>金额</th>
                    <th>描述</th>
                    <th>日期</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->userName }}</td>
                        <td>{{ $item->typeName }}</td>
                        <td>{{ $item->formatAmount }}</td>
                        <td>{{ $item->describe }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            @if($item->type == \App\Consts\Common\AccountFlowTypeConst::RECHARGE && $item->hedging_id == 0)
                            <div class="btn-group">
                                <button class="btn btn-default hedging" data-title="用户:{!! $item->userName  !!},对冲金额:{!! str_replace('+', '-', $item->formatAmount ) !!}"
                                        data-href="{!! route('m.customer.recharge.hedging', ['id' => $item->id]) !!}">对冲</button>
                            </div>
                            @endif
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
            $('.hedging').click(function() {
                var _this = $(this);

                swal({
                            title: $(this).attr('data-title'),
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