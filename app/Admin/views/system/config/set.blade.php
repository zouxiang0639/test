@extends('admin::layouts.master')

@section('content-header')
    <h1>
        配置<small>设置</small>
    </h1>
@stop
@section('content')

    <div class="box">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">网址配置</a></li>
                <li><a href="#meal" data-toggle="tab">点餐配置</a></li>
                <li><a href="#takeout" data-toggle="tab">外面配置</a></li>
                <li class="btn-primary" style="float: right;"><a style="color: white" href="{!! route('m.system.config.list') !!}" >配置列表</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    {!! $form !!}
                </div>

                <div class="tab-pane" id="meal">
                    {!! $mealForm !!}
                </div>

                <div class="tab-pane" id="takeout">
                    {!! $takeoutForm !!}
                </div>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.system.config.set.post') !!}",
            "backUrl":"{!! route('m.system.config.set') !!}"
        }
    </script>
@stop