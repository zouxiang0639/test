@extends('h5::layouts.master')

@section('content')
    <div class="plate-box">
        <ul class="clearfix">
            @foreach($list as $key => $item)
            <li>
                <a href="{!! route('h.article.list', ['tag' => $item['id']]) !!}">
                    <i @if($key == 1)  style="background-color: #e9711a; color: white;" @else style="color:{{ $item->color }}" @endif class="{{ $item->icon }} ico "></i>
                    <p>{!! $item->tag_name !!}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
@stop