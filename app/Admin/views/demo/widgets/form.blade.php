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
                <textarea id="a"></textarea>
        </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        function formValidate()
        {
            //解决ckeditor编辑器 ajax上传问他
            if(typeof CKEDITOR=="object"){
                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        }

        var initialAjAx = {
            "url":"{!! route('m.role.store') !!}",
            "backUrl":"{!! route('m.role.list') !!}"
        };

    </script>
@stop