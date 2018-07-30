<div class="com-top">
    <div class="wm-850 clearfix">
        <a class="logo" href="javascript:void(0)">
            <img src="{!! assets_path("/forum/img/logo.png") !!}" alt="" title="" />
        </a>
        <div class="right">
            <div class="login-state">
                <!--登陆后的状态-->
                @if(Auth::guard('forum')->check())
                    <span class="news"><i></i>2</span>
                    <a  href="{!! route('f.member.index') !!}">{!! Auth::guard('forum')->user()->name !!}</a>
                @else
                    <a  class="register" data-toggle="modal" data-target="#registerModal" href="javascript:void(0)">注册</a>
                    <a  class="login" data-toggle="modal" data-target="#loginModal" href="javascript:void(0)">登陆</a>
                @endif

            </div>
            <div class="search clearfix">
                <input class="s-txt" type="text" placeholder="" />
                <a class="s-btn" href="javascript:void(0)"></a>
            </div>
        </div>
    </div>
</div>
<div class="com-header">
    <div class="wm-850 clearfix">
        <a href="javascript:void(0)">热门</a>
        <a href="javascript:void(0)">最新</a>
        <a href="javascript:void(0)">公告</a>
    </div>
</div>
<?php
    $tags =  Forum::getTags();
?>
<div class="com-nav">
    <div class="wm-850">
        <div class="nav clearfix">
            <div class="nav-list fl clearfix">
                @foreach($tags as $value)
                    <a class="{{ $value['icon'] }}" href="{!! route('f.article.list', ['id' => $value['id']]) !!}" title="{{ $value['tag_name'] }}" ></a>
                @endforeach
            </div>
            <a class="post fr" href="{!! route('f.article.create') !!}"><i></i>发帖</a>
        </div>
    </div>
</div>