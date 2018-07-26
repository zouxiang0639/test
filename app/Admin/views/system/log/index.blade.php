@extends('admin::layouts.master')

@section('style')

@stop

@section('content-header')
    <h1>
        系统日志<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="row">
        <!-- /.col -->
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">系统日志</h3>
                    <div class="pull-right">
                        <div class="btn-group">
                        @if ($prevUrl)
                        <a href="{{ $prevUrl }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
                        @endif
                        @if ($nextUrl)
                        <a href="{{ $nextUrl }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
                        @endif
                        </div>
                                <!-- /.btn-group -->
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">

                    <div class="table-responsive">
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>等级</th>
                                <th>环境</th>
                                <th>日期</th>
                                <th>消息</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($logs as $index => $log)

                                <tr>
                                    <td><span class="label bg-{{\App\Library\Admin\Log\LogViewer::$levelColors[$log['level']]}}">{{ $log['level'] }}</span></td>
                                    <td><strong>{{ $log['env'] }}</strong></td>
                                    <td style="width:150px;">{{ $log['time'] }}</td>
                                    <td><code style="word-break: break-all;">{{ $log['info'] }}</code></td>
                                    <td>
                                        @if(!empty($log['trace']))
                                            <a class="btn btn-primary btn-xs" data-toggle="collapse" data-target=".trace-{{$index}}"><i class="fa fa-info"></i>&nbsp;&nbsp;Exception</a>
                                        @endif
                                    </td>
                                </tr>

                                @if (!empty($log['trace']))
                                    <tr class="collapse trace-{{$index}}">
                                        <td colspan="5"><div style="white-space: pre-wrap;background: #333;color: #fff; padding: 10px;">{{ $log['trace'] }}</div></td>
                                    </tr>
                                @endif

                            @endforeach

                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>

        <div class="col-md-2">

        <div class="box box-solid">
        <div class="box-header with-border">
        <h3 class="box-title">Files</h3>
        </div>
        <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
        @foreach($logFiles as $logFile)
        <li @if($logFile == $fileName)class="active"@endif>
        <a href="{{ route('m.system.log.list', ['file' => $logFile]) }}"><i class="fa fa-{{ ($logFile == $fileName) ? 'folder-open' : 'folder' }}"></i>{{ $logFile }}</a>
        </li>
        @endforeach
        </ul>
        </div>
        <!-- /.box-body -->
        </div>

        <div class="box box-solid">
        <div class="box-header with-border">
        <h3 class="box-title">Info</h3>
        </div>
        <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
        <li class="margin: 10px;">
        <a>Size: {{ $size }}</a>
        </li>
        <li class="margin: 10px;">
        <a>Updated at: {{ date('Y-m-d H:i:s', filectime($filePath)) }}</a>
        </li>
        </ul>
        </div>
        <!-- /.box-body -->
        </div>

        <!-- /.box -->
        </div>
                <!-- /.col -->
    </div>

@stop

@section('script')

@stop