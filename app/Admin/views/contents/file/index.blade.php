@extends('admin::layouts.master')

@section('style')
    <style>
        .no-padding{
            border-top: 1px solid #f4f4f4;
        }
        .col-sm-3{
            margin-top: 10px;
        }
    </style>
@stop

@section('content-header')
    <h1>
         文章<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline" name="search" action="">
                    <div class="input-group input-group-sm ">
                        <div class="box box-body  box-solid box-default no-margin" style="padding: 4px 10px">
                            {!! Form::checkbox('recycle', 1, Input::get('recycle')) !!} 回收站
                        </div>
                    </div>

                    <div class="input-group input-group-sm ">
                        {!! Form::text('id', Input::get('id'), ['class'=>'form-control','placeholder'=>'文章ID']) !!}
                    </div>
                    <div class="input-group input-group-sm" >
                        {!! Form::text('title', Input::get('title'), ['class'=>'form-control','placeholder'=>'标题']) !!}
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                </form>

            </div>

            <div class="pull-right">

            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
                @foreach($list as $item)
                    <div class="col-sm-3 col-md-2">
                        <div class="thumbnail">
                            <img id='preview-{!! $item->id !!}' title="{!! $item->path !!}" alt="{!! $item->path !!}"  style="height: 120px; width: 100%;cursor: hand; display: block;" src="{!! uploads_path($item->path) !!}">
                            <div class="caption">
                                <button  class="btn btn-primary item-delete"  data-url="{!! route('m.contents.file.destroy', ['id' => $item->id]) !!}">
                                    删除
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>

        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->
    </div>

@stop