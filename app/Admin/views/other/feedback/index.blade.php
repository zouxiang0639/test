@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        客户反馈<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <ul class="nav nav-tabs nav-tabs-custom" style="margin-bottom: 0px">
                    @foreach($type as $key => $value)
                        <li {!! $key == Input::get('type') ?'class="active"' : '' !!}><a href="{!! route('m.other.feedback.list', ['type' => $key]) !!}">{!! $value !!}</a></li>
                    @endforeach
                    <li class="pull-right header"></li>
                </ul>
            </div>
        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>类型</th>
                    <th>用户名</th>
                    <th>订单</th>
                    <th>评分</th>
                    <th>反馈内容</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{!! $item->typeName !!}</td>
                        <td>{{ $item->usersName }}</td>
                        <td><a href="{!! route('m.customer.order.show', ['id' => $item->extend['order_id']]) !!}">{{ $item->extend['title'] }}</a></td>
                        <td>{{ $item->extend['num'] }}</td>
                        <td>{{ $item->contentsMb }}</td>
                        <td>{!! $item->created_at !!}</td>
                        <td>
                            <a href="{!! route('m.other.feedback.show', ['id' => $item->id]) !!}">
                                <i class="fa fa-eye"></i>
                            </a>

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

    </script>
@stop