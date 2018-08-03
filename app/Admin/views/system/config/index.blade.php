@extends('admin::layouts.master')

@section('content-header')
    <h1>
        配置<small>列表</small>
    </h1>
@stop
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="btn-group" style="margin-right: 10px">
                <a href="{!! route('m.system.config.set') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;返回
                </a>
                <a href="{!! route('m.system.config.create') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
            </div>

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
                    <th>配置名称</th>
                    <th>配置值</th>
                    <th>描述</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{!! $item->created_at !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td>
                            <a href="{!! route('m.system.config.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.system.config.destroy', ['id' => $item->id]) !!}" class="item-delete">
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