@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        公告<small>编辑</small>
    </h1>
@stop
@section('content')

    <div class="row"><div class="col-md-12"><div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{!! route('m.contents.notice.list') !!}" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                {!! $form !!}
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
            "url":"{!! route('m.contents.notice.update', ['id' => $info->id]) !!}",
            "backUrl":"{!! route('m.contents.notice.list') !!}"
        }
    </script>
@stop