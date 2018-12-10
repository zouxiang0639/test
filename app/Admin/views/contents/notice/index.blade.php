@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
@stop

@section('content-header')
    <h1>
         公告<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">

            </div>

            <div class="pull-right">
                <a href="{!! route('m.contents.notice.create') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>标题</th>
                    <th>推荐首页</th>
                    <th>创建时间</th>
                    <th width="100">操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->title }}</td>
                        <td class="switch_submit" data-href="{!! route('m.contents.notice.ishome', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->is_home) !!}
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{!! route('m.contents.notice.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.contents.notice.destroy', ['id' => $item->id]) !!}" class="item-delete">
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

@section('script')
@stop