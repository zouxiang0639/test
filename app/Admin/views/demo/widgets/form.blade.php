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

                <div class="form-group ">
                    <label for="1" class="col-sm-2 control-label">1</label>
                    <div class="col-sm-8">
                        <input type="checkbox" class="1 la_checkbox" />
                        <input type="hidden" class="1" name="1" class="" value="off" />
                    </div>
                </div>
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