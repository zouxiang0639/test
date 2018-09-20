@if($replyAd)
<li style="padding: 0px;">
    <a  href="{!! $replyAd->links !!}">
    <img src="{!! uploads_path($replyAd->picture) !!}" title="{!! $replyAd->title  !!}">
    </a>
    <span style="color: #000;   position: absolute;bottom: 3px;right: 6px;">广告 <a href="javascript:;" onclick="deleteAb(this)">关闭</a></span>
</li>
@endif
