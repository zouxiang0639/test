<div class="header clearfix">
    <div class="logo fl"><a href="javascript:void(0)"><img src="{{  assets_path("/h5/img/logo.png") }}" alt="" title="" /></a></div>
    <div class="hd-link fr clearfix">
        <a class="info-link" href="javascript:void(0)">
            <i class="icon"></i>
            <span>2</span>
        </a>
        <a class="my-link" href="{!! route('h.auth.login') !!}"></a>
        <a class="edit-link" href="{!! route('h.article.create') !!}"></a>
        <a class="search-link" href="javascript:void(0)"></a>
    </div>
</div>
<div class="menu-box">
    <a class="on" href="javascript:void(0)">热门</a>
    <a href="javascript:void(0)">最新</a>
    <a href="javascript:void(0)">公告</a>
    <a href="{!! route('h.article.category') !!}">板块</a>
</div>