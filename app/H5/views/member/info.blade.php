@extends('h5::layouts.master')

@section('style')
<style>
    .old p{
        color: #999999;
    }
    .tab-tit {
        margin-top: 0.1rem;
        height:0.48rem;
        background: #31465b;
        position: relative;
    }
    .tab-tit li.on {
        background: #fff;
        color: #000;
    }
    .tab-tit li {
        float: left;
        height: 0.48rem;
        width: 25%;
        border-right: 1px solid #607080;
        text-align: center;
        color: #fff;
        line-height: 0.48rem;
        cursor: pointer;
    }
    .tab-tit li:last-child {
        border-right: 0px solid #1A3148;
    }
</style>
@stop
@section('content')
    @include("h5::partials.member_info")
    <div class="tab-tit">
        <ul class="clearfix">
            @foreach($type as $key => $value)
                <li @if(Input::get('type') == $key) class="on" @endif onclick="window.location.href='{!! route('h.member.info',['type' => $key]) !!}'">
                    {!! $value !!}
                </li>
            @endforeach

        </ul>
        {{--<a class="read info-sign" href="javascript:void(0)">全部设为已读</a>--}}
    </div>
    <div class="list-box" >
        <ul style="margin-bottom: 0px;">
            @foreach($list as $item)
                <li  {!! $item->sign == 1 ? 'class="old"' : ''!!}>
                    <div class="tit clearfix">

                        <p>{!! str_replace('/article', '/h5/article' ,$item->content) !!}</p>
                    </div>
                    <div class="des clearfix">
                        <p>
                            <i class="name">{{ $item->typeName }}</i>
                            <i class="date">{!!  $item->createdAt !!}</i>

                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="page-box clearfix">
        {!! $list->appends(Input::get())->render() !!}
    </div>
@stop