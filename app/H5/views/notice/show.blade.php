@extends('h5::layouts.master')
@section('content')
    <div class="pages">
        <div class="post-con">
            <div class="post-tit">{!! $info->title !!}</div>

            <div class="post-txt">

                <div class="tep3">
                    {!! $info->contents !!}
                </div>
            </div>
        </div>
    </div>
@stop
