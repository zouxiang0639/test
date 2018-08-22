@extends('forum::layouts.master')

@section('content')
    <div class="com-hot">
        <div class="wm-850">
            <div class="hot">
                <div class="hot-tit clearfix">
                    <span class="icon fl"></span>
                    <a class="more fr" href="{!! route('f.article.gather', ['type' => 'hot']) !!}">+ more</a>
                </div>
                <div class="hot-list">
                    <ul class="clearfix">
                        @foreach($hot as $value)
                            <li>
                                <a href="{!! route('f.article.info', ['id' => $value->id]) !!}">
                                    <span>
                                        <i style="color:{!!  Forum::Tags()->getTagsColor($value->tags) !!} "
                                           class="{!!  Forum::Tags()->getTagsIcon($value->tags) !!}"></i>
                                    </span>
                                    {!! $value->title !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('forum::partials.ad')
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container">
                <div class="new-tit"><i></i></div>
                @include('forum::partials.all_article')
            </div>
        </div>
    </div>
@stop