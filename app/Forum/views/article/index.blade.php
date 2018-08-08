@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
@stop

@section('content')
    <div class="list-container">
        <div class="wm-850">
            <div class="list">
                <div class="list-txt">
                    <p style="color: #cccccc;line-height:20px;">这里是幽默板块</p>
                    <p style="color: #cccccc;line-height:20px;">您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容</p>
                    <p style="color: #cccccc;line-height:20px;">其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块</p>
                </div>
                <div class="list-other">
                    点击查看{!! $tags->tag_name !!}板块→
                    <a href="{!! route('f.article.list', ['tag' => $tags->id, 'order' => 'hot']) !!}">热门</a>
                    <a href="{!! route('f.article.list', ['tag' => $tags->id, 'order' => 'new']) !!}">最新</a>
                </div>
            </div>
        </div>
    </div>
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container" style="min-height: 400px;">
                @if(Input::get('order') == 'hot')
                    <div class="hot-tit clearfix" style="width: 827px;margin: 0 auto;">
                        <span class="icon fl" style="margin: 2px 0 0 8px;"></span>
                    </div>
                @else
                    <div class="new-tit"><i></i></div>
                @endif

                @include('forum::article.all')
            </div>
        </div>
    </div>
@stop