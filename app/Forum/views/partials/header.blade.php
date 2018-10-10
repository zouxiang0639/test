<?php
use App\Consts\Common\SearchType;
?>


<div class="com-top">
    <div class="wm-850 clearfix">
        <a class="logo" href="{!! route('f.home') !!}">
            <img src="{!! uploads_path(config('config.logo')) !!}" alt="" title="" />
        </a>
        <div class="right">
            <div class="login-state">
                <!--登录后的状态-->
                @if(Auth::guard('forum')->check())
                     <?php
                    $count = \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO);
                    ?>
                    <span class="news">
                         <a style="{!! $count ? 'color: #e15844;': 'color: #999999;' !!}" href="{!! route('f.member.info') !!}" >
                        <i class="icon-alarm"></i>{!! \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO) !!}
                         </a>
                    </span>

                    <a  href="{!! route('f.member.index') !!}">{!! Auth::guard('forum')->user()->name !!}</a>
                    <a  href="{!! route('f.auth.logout') !!}">退出</a>
                @else
                    <a  class="register" data-toggle="modal" data-target="#registerModal" href="javascript:void(0)">注册</a>
                    <a  class="login" data-toggle="modal" data-target="#loginModal" href="javascript:void(0)">登录</a>
                @endif

            </div>

            <div class="search clearfix">
               <form id="search-form" action="{!! route('f.article.search') !!}">

                   {!! Form::select('type_key', SearchType::desc(), Input::get('type_key'), ['style'=>'margin: 5px 0 0px 10px;color: #479fed;padding-right: 2px;border: 0;float: left;background: #31465b;']) !!}
                   <input style="width: 177px" class="s-txt" type="text" name="key" placeholder="{!! Input::get('key') !!}" />
                   <a class="s-btn icon-search" id="search-submit" href="javascript:void(0)"></a>

               </form>
            </div>
        </div>
    </div>
</div>

<div class="com-header">
    <div class="wm-850 clearfix">
        <a href="{!! route('f.article.gather', ['type' => 'hot']) !!}">热门</a>
        <a href="{!! route('f.article.gather') !!}">最新</a>
        <a href="{!! route('f.notice.list') !!}">公告</a>
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
                       href="{!! route('f.article.list', ['tag' => $value['id']]) !!}" data-toggle="tooltip"  title="{{ $value['tag_name'] }}" >
                        <i  @if($key == 1)  style="background-color: #e9711a; color: white;" @endif class="{!! $value['icon'] !!}"></i>
                    </a>
                @endforeach
            </div>
            <a class="post fr" href="{!! route('f.article.create') !!}"><i class="icon-post"></i>发帖</a>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script>
        $(function() {
            $('#search-submit').click(function() {
                var key = $('.search input[name=key]').val();
                if(key == '') {
                    swal("请输入关键字", '', 'error');
                    return false;
                }
                document.getElementById("search-form").submit();
            })
        })
    </script>
@stop