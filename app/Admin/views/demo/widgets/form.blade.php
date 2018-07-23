@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        示例<small>Form表单</small>
    </h1>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>
                </div>
                {!! $form !!}
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.role.store') !!}",
            "backUrl":"{!! route('m.role.list') !!}"
        };

    </script>
@stop