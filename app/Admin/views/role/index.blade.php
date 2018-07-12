@extends('admin::layouts.master')

@section('content-header')
    <style>
        .label{line-height: 2;}
    </style>
@stop

@section('content-header')
    <h1>
        管理员<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            <h3 class="box-title"></h3>

            <div class="pull-right">
            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th></th>
                    <th>ID
                        <a class="fa fa-fw fa-sort-amount-asc" href="http://bbs.com/admin/auth/users?_sort%5Bcolumn%5D=id&amp;_sort%5Btype%5D=desc"></a>
                    </th>
                    <th>标识</th>
                    <th>名称</th>
                    <th>权限</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td></td>
                        <td>{!! $item->id !!}</td>
                        <td>{!! $item->username !!}</td>
                        <td>{!! $item->name !!}</td>
                        <td>
                            @if($roles = $item->permissions)
                                @foreach($roles as $value)
                                    <span class="label label-success">{!! $value->name !!}</span>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td>{!! $item->created_at !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td>
                            <a href="{!! route('m.user.edit', ['id' => $item->id]) !!}">
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