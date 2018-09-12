@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
    <style>
        .img img{
            max-width: 24%;
            padding: 5px;
        }
    </style>
@stop

@section('content')
    <div class="art-info" style="margin-top: 10px">
        <div class="wm-850">
            <div class="art-con">
                <p class="tit">{!! $info->title !!}</p>
                <div class="con-in">
                    {!! $info->contents !!}
                </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
@parent
<script>

</script>
@stop
