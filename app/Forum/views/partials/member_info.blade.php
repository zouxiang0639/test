<div class="com-info">
    <div class="wm-850">
        <div class="info">
            <div class="step1">
                <a class="edit" href="javascript:void(0)"></a>
                <a class="right" href="javascript:void(0)"></a>
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
                        <span><i>？</i>积分 ：{!! $info->integral !!}</span>
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
                    <li>
                        <a href="{!! route('f.member.recommend') !!}">
                            <span class="tit">推荐</span>
                            <span class="num">{!! $articlesRecommendCount !!}</span>
                            {!! $current == 3 ? '<i></i>' : '' !!}
                        </a>
                    </li>
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
                            <span class="num">20</span>
                            {!! $current == 5 ? '<i></i>' : '' !!}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>