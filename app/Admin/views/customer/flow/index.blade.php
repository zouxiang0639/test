@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        账户流水<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline">
                    <div class="input-group input-group-sm" style="min-width: 100px">
                        {!! Form::select2('user_id', $usersList,
                        Input::get('user_id'), ['class' => 'form-control', 'placeholder'=>'全部用户']) !!}
                    </div>
                    <div class="input-group input-group-sm " style="width: 150px;">
                        {!! Form::select('type', \App\Consts\Common\AccountFlowTypeConst::desc(),
                       Input::get('type'), ['class' => 'form-control', 'placeholder'=>'请选择类型']) !!}
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
                    <th>用户</th>
                    <th>类型</th>
                    <th>金额</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->userName }}</td>
                        <td>{{ $item->typeName }}</td>
                        <td>{{ $item->formatAmount }}</td>
                        <td>{{ $item->describe }}</td>
                        <td>
                            <a href="{!! route('m.customer.users.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
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