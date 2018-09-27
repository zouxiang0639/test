@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        本周外卖统计<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <a href="{!! route('m.report.takeout.export') !!}" class="btn btn-sm btn-success">
                    导出本周外卖菜单
                </a>

                <a href="{!! route('m.report.takeout.user.export') !!}" class="btn btn-sm btn-success">
                    导出本周用户外卖菜单
                </a>
            </div>
        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>外卖名称</th>
                    <th>预购数量</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item['name'] !!}</td>
                        <td>{!! $item['num'] !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <!-- /.box-body -->
    </div>

@stop

@section('script')
    <script>

    </script>
@stop