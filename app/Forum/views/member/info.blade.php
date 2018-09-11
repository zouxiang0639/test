@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
@stop

@section('content')

    @include('forum::partials.member_info')

    <div class="info-continer">
        <div class="wm-850">
            <div class="info-tab">
                <div class="tab-tit">
                    {{--<ul class="clearfix">--}}
                        {{--<li class="on">回复<span>3</span></li>--}}
                        {{--<li>帖子<span>5</span></li>--}}
                        {{--<li>管理员<span>1</span></li>--}}
                    {{--</ul>--}}
                    <a class="read info-sign" href="javascript:void(0)">全部设为已读</a>
                </div>
                <div class="tab-con">
                    <ul>
                        @foreach($list as $item)
                            <li  {!! $item->sign == 2 ? 'class="new"' : ''!!}>
                                <span class="time">{!! mb_substr($item->created_at, 0, 10) !!}</span>
                                <span class="type">{{ $item->typeName }}</span>
                                <span class="con">{!! $item->content  !!}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="com-page">
                        {!! $list->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    @parent
    <script>
        $(function(){
            var locked = true;
            $('.info-sign').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: "{!! route('f.member.info.sign') !!}",
                    type: 'POST',
                    data: {
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = document.location;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });
            })
        })
    </script>
@stop