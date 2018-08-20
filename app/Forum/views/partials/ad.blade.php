@if(!empty($ad))
    <div class="com-ad">
        <div class="wm-850">
            <a class="ad" href="{!! $ad->links !!}">
                <img src="{!! uploads_path($ad->picture) !!}" alt="" title="{!! $ad->title  !!}" /><span>广告</span>
            </a>
        </div>
    </div>
@endif