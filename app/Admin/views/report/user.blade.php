@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        统计<small>用户消费统计</small>
    </h1>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">创建</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{!! route('m.system.tags.list') !!}" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>


                <div class="form-horizontal box-body fields-group">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            用户当前余额:
                        </label>
                        <div class="col-sm-7 type">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default no-margin">分组</div><input name="type" value="1" type="hidden">

                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">

                            <span class="text-danger">*</span>
                            标签名称:
                        </label>
                        <div class="col-sm-7 tag_name">
                            <div class="input-group" style="width:100%">
                                <input class="form-control" name="tag_name" type="text">

                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">

                            <span class="text-danger">*</span>
                            热度:
                        </label>
                        <div class="col-sm-7 hot">
                            <div class="input-group" style="width:100%">
                                <input class="form-control" name="hot" type="text">

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.system.tags.store') !!}",
            "backUrl":"{!! route('m.system.tags.list', ['type' => Input::get('type')]) !!}"
        }
    </script>
@stop