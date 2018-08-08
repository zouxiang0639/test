@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
@stop

@section('content')
    @include('forum::partials.ad')
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container" style="min-height: 400px;">
                @if(Input::get('type') == 'new')
                    <div class="new-tit"><i></i></div>
                @elseif(Input::get('type') == 'hot')
                    <div class="hot-tit clearfix" style="width: 827px;margin: 0 auto;">
                        <span class="icon fl" style="margin: 2px 0 0 8px;"></span>
                    </div>
                @endif

                @include('forum::article.all')
            </div>
        </div>
    </div>
@stop