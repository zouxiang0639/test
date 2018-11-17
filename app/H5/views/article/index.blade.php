@extends('h5::layouts.master')

@section('content')
    <div class="list-menu">
        <p>{!! str_replace("\r\n",'<br>', $tags->contents) !!}</p>
        <p>点击查看{!! $tags->tag_name !!}板块-->
            <a @if(Input::get('order') == 'hot') class="on" @endif href="{!! route('h.article.list', ['tag' => $tags->id, 'order' => 'hot']) !!}">热门</a>
            <a @if(Input::get('order') == 'new') class="on" @endif href="{!! route('h.article.list', ['tag' => $tags->id, 'order' => 'new']) !!}">最新</a></p>
    </div>

    @include('h5::article.article_list')
@stop