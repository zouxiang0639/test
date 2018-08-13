@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        用户反馈<small>展示</small>
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
                            类型:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default no-margin">
                                    {!! $info->typeName !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            用户:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default no-margin">
                                    {{ $info->usersName }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($extend as $key => $value)

                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                {!! $key !!}:
                            </label>
                            <div class="col-sm-7 ">
                                <div class="input-group" style="width:100%">
                                    <div class="box box-body  box-solid box-default no-margin">
                                        {{ $value }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            内容:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default no-margin">
                                    {!! $info->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            创建时间:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default no-margin">
                                    {!! $info->created_at !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">

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