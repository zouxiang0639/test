@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        就餐预约统计<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <a href="{!! route('m.report.meal.export') !!}" class="btn btn-sm btn-success">
                   导出Excel
                </a>
            </div>
        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>日期</th>
                    <th>就餐</th>
                    <th>数量</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item['date'] !!}</td>
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