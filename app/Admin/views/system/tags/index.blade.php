@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
    <link rel="stylesheet" href="{{  assets_path("/lib/icomoon/style.css") }}">
@stop

@section('content-header')
    <h1>
        标签<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <ul class="nav nav-tabs nav-tabs-custom" style="margin-bottom: 0px">
                    @foreach($tagsType as $key => $value)
                        <li {!! $key == Input::get('type') ?'class="active"' : '' !!}><a href="{!! route('m.system.tags.list', ['type' => $key]) !!}">{!! $value !!}</a></li>
                    @endforeach
                    <li class="pull-right header"></li>
                </ul>
            </div>

            <div class="pull-right">
                <a href="{!! route('m.system.tags.create', ['type' => Input::get('type')]) !!}" class="btn btn-sm btn-success">
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
                    <th>热度</th>
                    <th>标签名称</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>
                            <a href="javascript:;" class="hot" data-pk="{!! $item->id !!}">{!! $item->hot !!}</a>
                        </td>
                        <td>{{ $item->tag_name }}</td>
                        <td class="switch_submit" data-href="{!! route('m.system.tags.status', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->status) !!}
                        </td>
                        <td>{!! $item->created_at !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td>
                            <a href="{!! route('m.system.tags.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.system.tags.destroy', ['id' => $item->id]) !!}" class="item-delete">
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
    <script src="{{  assets_path("/lib/bootstrap3-editable/js/bootstrap-editable.min.js") }}"></script>
    <script>
        $(function(){
            $('.hot').editable({
                url: "{!! route('m.system.tags.hot') !!}",
                type: 'text',
                params: {
                    "_method": "PUT",
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                pk: $(this).attr('data-pk'),//唯一标示值
                title: '修改',
                name: 'hot',
                success: function(value) {
                    $(this).text(value);
                }
            });
        })
    </script>
@stop