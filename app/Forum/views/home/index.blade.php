@extends('forum::layouts.master')

@section('content')
    <div class="com-hot">
        <div class="wm-850">
            <div class="hot">
                <div class="hot-tit clearfix">
                    <span class="icon fl"></span>
                    <a class="more fr" href="javascript:void(0)">+ more</a>
                </div>
                <div class="hot-list">
                    <ul class="clearfix">
                        <li><a href="javascript:void(0)"><i class="i-1"></i>生娃已有六个月，目前为止没有一次性生活，这样正常..</a></li>
                        <li><a href="javascript:void(0)"><i class="i-2"></i>生娃已有六个月，目前为止没有一次性生活，这样正常..</a></li>
                        <li><a href="javascript:void(0)"><i class="i-3"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）</a></li>
                        <li><a href="javascript:void(0)"><i class="i-4"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）</a></li>
                        <li><a href="javascript:void(0)"><i class="i-1"></i>老婆精神出轨，我该原谅她吗？</a></li>
                        <li><a href="javascript:void(0)"><i class="i-5"></i>老婆精神出轨，我该原谅她吗？</a></li>
                        <li><a href="javascript:void(0)"><i class="i-3"></i>婆婆用搬回老家做威胁媳妇降级化妆品，你愿意妥协么</a></li>
                        <li><a href="javascript:void(0)"><i class="i-5"></i>婆婆用搬回老家做威胁媳妇降级化妆品，你愿意妥协么</a></li>
                        <li><a href="javascript:void(0)"><i class="i-3"></i>婆婆真的没义务带孙子吗</a></li>
                        <li><a href="javascript:void(0)"><i class="i-6"></i>婆婆真的没义务带孙子吗</a></li>
                        <li><a href="javascript:void(0)"><i class="i-7"></i>鸿茅药酒案谭医生突发精神疾病，别误以为取保候审就..</a></li>
                        <li><a href="javascript:void(0)"><i class="i-8"></i>鸿茅药酒案谭医生突发精神疾病，别误以为取保候审就..</a></li>
                        <li><a href="javascript:void(0)"><i class="i-7"></i>终于等到你，我的爱情开出一朵花</a></li>
                        <li><a href="javascript:void(0)"><i class="i-9"></i>终于等到你，我的爱情开出一朵花</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('forum::partials.ad')
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container">
                <div class="new-tit"><i></i></div>
                @include('forum::partials.all_article')
            </div>
        </div>
    </div>
@stop