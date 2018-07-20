@extends('admin::layouts.master')

@section('style')
@stop
@section('content-header')
    <h1>
        管理员<small>列表</small>
    </h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! $list !!}
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12"><div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">新增</h3>
                        </div>
                        {!! $form !!}

                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.menu.store') !!}",
            "backUrl":"{!! route('m.menu.list') !!}"
        }
    </script>
    @stop