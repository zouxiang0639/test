@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
@stop

@section('content')
    @include('forum::partials.ad')
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container" style="min-height: 400px;">
                @include('forum::article.all')
            </div>
        </div>
    </div>
@stop