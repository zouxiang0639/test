@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">空地社区用户注册协议</div>

                    <div class="post-txt">

                        <div class="tep3">

                            {!! $info !!}

                        </div>

                    </div>
            </div>
        </div>
    </div>
@stop
