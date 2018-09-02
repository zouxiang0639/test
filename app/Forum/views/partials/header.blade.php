<div class="com-top">
    <div class="wm-850 clearfix">
        <a class="logo" href="{!! route('f.home') !!}">
            <img src="{!! assets_path("/forum/img/logo.png") !!}" alt="" title="" />
        </a>
        <div class="right">
            <div class="login-state">
                <!--登陆后的状态-->
                @if(Auth::guard('forum')->check())

                    <span class="news">
                         <a style=" color: #e15844;" href="{!! route('f.member.info') !!}" >
                        <i class="icon-alarm"></i>{!! \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO) !!}
                         </a>
                    </span>

                    <a  href="{!! route('f.member.index') !!}">{!! Auth::guard('forum')->user()->name !!}</a>
                    <a  href="{!! route('f.auth.logout') !!}">退出</a>
                @else
                    <a  class="register" data-toggle="modal" data-target="#registerModal" href="javascript:void(0)">注册</a>
                    <a  class="login" data-toggle="modal" data-target="#loginModal" href="javascript:void(0)">登陆</a>
                @endif

            </div>
            <div class="search clearfix">
                <input class="s-txt" type="text" placeholder="" />
                <a class="s-btn icon-search" href="javascript:void(0)"></a>
            </div>
        </div>
    </div>
</div>
<div class="com-header">
    <div class="wm-850 clearfix">
        <a href="{!! route('f.article.gather', ['type' => 'hot']) !!}">热门</a>
        <a href="{!! route('f.article.gather', ['type' => 'new']) !!}">最新</a>
        <a href="javascript:void(0)">公告</a>
    </div>
</div>
<?php
    $tagsList =  Forum::tags()->getTagsList();
?>
<div class="com-nav">
    <div class="wm-850">
        <div class="nav clearfix">
            <div class="nav-list fl clearfix">
                @foreach($tagsList as $key =>$value)
                    <a class="{!! isset($tags) && $value->id == $tags->id ? "icon-default" : "" !!} "
                       href="{!! route('f.article.list', ['tag' => $value['id']]) !!}" title="{{ $value['tag_name'] }}" >
                        <i  @if($key == 1)  style="background-color: #e9711a; color: white;" @endif class="{!! $value['icon'] !!}"></i>
                    </a>
                @endforeach
            </div>
            <a class="post fr" href="{!! route('f.article.create') !!}"><i class="icon-post"></i>发帖</a>
        </div>
    </div>
</div>