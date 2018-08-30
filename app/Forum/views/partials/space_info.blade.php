<div class="com-info">
    <div class="wm-850">
        <div class="info">
            <div class="step1">

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
                        <a href="{!! route('f.space.index', ['user_id' => Input::get('user_id')]) !!}">
                            <span class="tit">发贴</span>
                            <span class="num">{!! $articleCount !!}</span>
                            {!! $current == 1 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('f.space.reply', ['user_id' => Input::get('user_id')]) !!}">
                            <span class="tit">回复</span>
                            <span class="num">{!! $replyCount !!}</span>
                            {!! $current == 2 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@section('script')
    @parent

@stop