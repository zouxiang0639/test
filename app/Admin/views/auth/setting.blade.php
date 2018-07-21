@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        用户设置<small>设置</small>
    </h1>
@stop
@section('content')

    <div class="row"><div class="col-md-12"><div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              {!! $form !!}
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.setting.update', ['id' => $info->id]) !!}",
            "backUrl":"{!! route('m.home') !!}"
        }
    </script>
@stop