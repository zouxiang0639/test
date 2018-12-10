@extends('h5::layouts.master')

@section('content')

    <div class="list-box" >
        <ul style="margin-bottom: 0px;">
            @foreach($list as $item)
                <li>
                    <div class="tit clearfix">
                        <a href="{!! route('h.notice.show', ['id'=> $item->id]) !!}">
                            <p>{{ $item->title }}<span style="padding-left: 5px">({!! mb_substr($item->created_at, 0,10) !!})</span></p>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="page-box clearfix">
        {!! $list->appends(Input::get())->links('h5::partials.pagination') !!}
    </div>
@stop