@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
    <style>
        .list-txt {
            color: #cccccc;line-height:20px;
        }
    </style>
@stop

@section('content')
    @include('forum::partials.ad')
    <div class="list-container">
        <div class="wm-850">
            <div class="list">
                <div class="list-txt">
                    {!! Forum::fragment()->get(3, 'contents') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="com-new">
        <div class="wm-850">
            <div class="new-container" style="min-height: 400px;">
                @if(Input::get('type') == 'hot')
                    <div class="hot-tit clearfix" style="width: 827px;margin: 0 auto;">
                        <span class="icon fl icon-hot" style="margin: 0px 0 0 8px;"></span>
                    </div>

                @else
                    <div class="new-tit"><i class="icon-new"></i></div>
                @endif

                @include('forum::article.all')
            </div>
        </div>
    </div>
@stop