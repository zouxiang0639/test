<div class="com-info">
    <div class="wm-850">
        <div class="info">
            <div class="step1">
                <a class="edit" href="javascript:void(0)"><i class="fa fa-pencil-square-o"></i></a>
                <a class="right sign-in" href="javascript:void(0)">
                    <i {!! mb_substr($info->sign_time, 0, 10) ==  date('Y-m-d') ? 'style="color:#F0E672"' : '' !!} class="fa fa-check-square-o"></i>
                </a>
            </div>
            <div class="step2">
                <div><p>{{ $info->name }}</p></div>
            </div>
            <div class="step3">
                <div>
                    <div>
                        <span>收到赞数：{!! $info->thumbs_up !!}</span><br />
                        <span>登录次数：{!! $info->login_num !!}</span><br />
                        <span>注册时间：{!! mb_substr($info->created_at, 0, 10) !!}</span><br />
                        <span><i>？</i>积分 ：
                            <span id="integral" data-num='{!! $info->integral !!}'>{!! $info->integral !!}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="step4">
                <ul class="clearfix">
                    <li>
                        <a href="{!! route('f.member.index') !!}">
                            <span class="tit">发贴</span>
                            <span class="num">{!! $articleCount !!}</span>
                            {!! $current == 1 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('f.member.reply') !!}">
                            <span class="tit">回复</span>
                            <span class="num">{!! $replyCount !!}</span>
                            {!! $current == 2 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="{!! route('f.member.recommend') !!}">--}}
                            {{--<span class="tit">推荐</span>--}}
                            {{--<span class="num">{!! $articlesRecommendCount !!}</span>--}}
                            {{--{!! $current == 3 ? '<i></i>' : '' !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{!! route('f.member.star') !!}">
                            <span class="tit">收藏</span>
                            <span class="num">{!! $articlesStarCount !!}</span>
                            {!! $current == 4 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('f.member.info') !!}">
                            <span class="tit">消息</span>
                            <span class="num">{!! $infoCount !!}</span>
                            {!! $current == 5 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script>
        $(function(){
            var locked = true;
            $('.sign-in').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: "{!! route('f.member.sign.in') !!}",
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
                            $('.sign-in i').css({color:"#F0E672"});
                            $('#integral').text(parseInt($('#integral').attr('data-num')) + 5);
                            locked = true;
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