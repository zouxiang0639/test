@extends('admin::layouts.master')

@section('content-header')
    <h1>
        权限<small>列表</small>
    </h1>
@stop
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="btn-group" style="margin-right: 10px">
                <a href="{!! route('m.permissions.create') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
            </div>
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
                    <th>路由</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td></td>
                        <td>{!! $item->id !!}</td>
                        <td>{!! $item->name !!}</td>
                        <td>{!! $item->slug !!}</td>
                        <td>
                            @foreach($item->http_path as $value)
                            <div style="margin-bottom: 5px;">
                                {!! Admin::tag($item->http_method ?: ['ANY'], 'label-primary') !!}
                                <code>{!! $value !!}</code>
                            </div>
                            @endforeach
                        </td>
                        <td>{!! $item->created_at !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td>
                            <a href="{!! route('m.permissions.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.permissions.destroy', ['id' => $item->id]) !!}" class="item-delete">
                                <i class="fa fa-trash"></i>
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