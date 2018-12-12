<div style="box-shadow: 0 0 0.2rem #061323">
    <div class="header clearfix">
        <div class="logo fl"><a href="{!! route('h.home') !!}"><img src="{{  assets_path("/h5/img/logo.png") }}" alt="" title="" /></a></div>
        <div class="hd-link fr clearfix">
            @if(Auth::guard('forum')->check())
                <?php
                $count = \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO);
                ?>
                <a  class="info-link" href="{!! route('h.member.info') !!}">
                    <i style="{!! $count ? 'color: #e15844;': 'color: #ffffff;' !!}" class="icon-alarm icon"></i>
                    <span style="{!! $count ? 'color: #e15844;': 'color: #ffffff;' !!}">{!! \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO) !!}</span>
                </a>
                <a class="my-link @if(\Request::route()->getAction('as') == 'h.member.index') on @endif"  href="{!! route('h.member.index') !!}">
                    <i class="icons-tops icon-user"></i>
                </a>
            @else

                <a class="my-link @if(\Request::route()->getAction('as') == 'h.auth.login') on @endif" href="{!! route('h.auth.login') !!}">
                    <i class="icons-tops icon-user"></i>
                </a>
            @endif

            <a class="edit-link check-auth  @if(\Request::route()->getAction('as') == 'h.article.create') on @endif" href="{!! route('h.article.create') !!}">
                <i class="icon-pencil icons-tops"></i>
            </a>
            <a class="search-link  @if(\Request::route()->getAction('as') == 'h.article.search') on @endif" href="{!! route('h.article.search') !!}">
                <i class="icons-tops  icon-search"></i>
            </a>
        </div>
    </div>
</div>

<div class="menu-box">
    <a @if(Input::get('type') == 'hot') class="on" @endif href="{!! route('h.home') !!}">热门</a>
    <a @if(Input::get('type') == 'new') class="on" @endif href="{!! route('h.home', ['type' => 'new']) !!}">最新</a>
    <a @if(\Request::route()->getAction('as') == 'h.notice.list') class="on" @endif href="{!! route('h.notice.list') !!}">公告</a>
    <a @if(\Request::route()->getAction('as') == 'h.article.category') class="on" @endif href="{!! route('h.article.category') !!}">板块</a>
</div>