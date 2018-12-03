<div class="list-box" >
    <ul style="margin-bottom: 0px;">
        @foreach($list as $item)
            <li>
                <div class="tit clearfix">
                    <a href="{!! route('h.article.info', ['id'=> $item->id]) !!}">
                        <i style="color:{!!  Forum::Tags()->getTagsColor($item->tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->tags) !!} icon"></i>
                        <p>{{ $item->title }}<span class="num">[{!! $item->replyCount !!}]</span></p>
                    </a>
                </div>
                <div class="des clearfix">
                    <p>
                        <i class="no">{!! $item->id !!}</i>
                        <i class="name">{!! $item->issuers ? $item->issuers->name : '-' !!}</i>
                        <i class="date">{!! $item->created_at !!}</i>
                        <span class="read"><i class="ico"></i>{!! $item->browse !!}</span>
                        <span class="good"><i  class="fa fa-thumbs-o-up"></i>
                            <span >{{ $item->recommend_count }}</span>
                        </span>
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div class="page-box clearfix">
    {!! $list->appends(Input::get())->render() !!}
</div>