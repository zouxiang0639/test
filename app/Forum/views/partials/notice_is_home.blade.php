
<div class="hot-list">
    <ul class="clearfix">
        @foreach($noticeList as $value)
            <li>
                <a href="{!! route('f.notice.show', ['id'=> $value->id]) !!}">
                    <span>
                        <i style="color:red;"
                           class="icon-bullhorn"></i>
                    </span>
                    {!! $value->title !!}（{!! mb_substr($value->created_at,0,10) !!}）
                </a>
            </li>
        @endforeach
    </ul>
</div>