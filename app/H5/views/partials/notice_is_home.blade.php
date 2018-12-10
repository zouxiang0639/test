<div class="list-box" >
    <ul style="margin-bottom: 0px;">
        @foreach($noticeList as $item)
            <li>
                <div class="tit clearfix">
                    <a href="{!! route('h.notice.show', ['id'=> $item->id]) !!}">
                        <i style="color:red; float: left " class="icon-bullhorn icon"></i>
                        <p style="float: left ;width: 90%;color: #9b9b9b">
                            {{ $item->title }}
                            （{!! mb_substr($item->created_at,0,10) !!}）
                        </p>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>