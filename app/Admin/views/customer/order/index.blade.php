@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        订单<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline">
                    <div class="input-group" style="min-width: 100px">
                        {!! Form::select2('user_id', $usersList,
                        Input::get('user_id'), ['class' => 'form-control', 'placeholder'=>'全部用户']) !!}
                    </div>
                    <div class="input-group input-group-sm">
                        {!! Form::select('type', $type,
                        Input::get('type'), ['class' => 'form-control', 'placeholder'=>'全部类型']) !!}
                    </div>
                    <div class="input-group input-group-sm">
                        {!! Form::select('status', $status,
                        Input::get('status'), ['class' => 'form-control', 'placeholder'=>'全部状态']) !!}
                    </div>
                    <div class="input-group input-group-sm " style="width: 150px;">
                        <input name="id" value="{!! Input::get('id') !!}" type="text" class="form-control" placeholder="订单编号">
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
                    <th>用户名</th>
                    <th>类型</th>
                    <th>产品详情</th>
                    <th>订单总金额</th>
                    <th>定金</th>
                    <th>已支付金额</th>
                    <th>状态</th>
                    <th>日期</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->userName }}</td>
                        <td>{{ $item->typeName }}</td>
                        <td>{{ $item->amountFormat }}</td>
                        <td>
                            @foreach($item->child as $value)
                                <p>
                                    {!! $value->name !!} - {!! $value->num !!} - {!!  $value->price !!}
                                </p>
                            @endforeach
                        </td>
                        <td>{{ $item->depositFormat }}</td>
                        <td>{{ $item->paymentFormat }}</td>
                        <td>{{ $item->statusName }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{!! route('m.customer.order.show', ['id' => $item->id]) !!}">
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

@stop