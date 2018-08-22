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