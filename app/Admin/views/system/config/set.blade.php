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
                {{--<li><a href="#timeline" data-toggle="tab">Timeline</a></li>--}}
                {{--<li><a href="#activity" data-toggle="tab">activity</a></li>--}}
                <li style="float: right"><a href="{!! route('m.system.config.list') !!}" >配置列表</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    {!! $form !!}
                </div>
                <div class="tab-pane" id="timeline">
                </div>

                <div class="tab-pane" id="activity">
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