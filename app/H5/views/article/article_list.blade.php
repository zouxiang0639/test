<div class="list-box">
    <ul>
        @foreach($list as $item)
            <li>
                <div class="tit clearfix">
                    <a href="{!! route('h.article.info', ['id'=> $item->id]) !!}">
                        <i style="color:{!!  Forum::Tags()->getTagsColor($item->tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->tags) !!} icon"></i>
                        <p>{{ $item->title }}<span class="num">[{!! $item->replyCount !!}]</span></p>
                    </a>

                </div>
                <div class="des clearfix">
                    <i class="no">97</i>
                    <p>
                        <i class="name">{!! $item->issuers ? $item->issuers->name : '-' !!}</i>
                        <i class="date">{!! $item->created_at !!}</i>
                        <span class="read"><i class="ico"></i>{!! $item->browse !!}</span>
                        <span class="good"><i class="ico"></i>{{ $item->recommend_count }}</span>
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div class="page-box clearfix">
    {!! $list->appends(Input::get())->render() !!}

</div>