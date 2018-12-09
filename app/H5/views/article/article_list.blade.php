<div class="list-box" >
    <ul style="margin-bottom: 0px;">
        @foreach($list as $item)
            <li>
                <div class="tit clearfix">
                    <a href="{!! route('h.article.info', ['id'=> $item->id]) !!}">
                        <i style="color:{!!  Forum::Tags()->getTagsColor($item->tags) !!}; float: left " class="{!!  Forum::Tags()->getTagsIcon($item->tags) !!} icon"></i>
                       <p style="float: left ;width: 90%">
                            {{ $item->title }}
                           <span class="num">[{!! $item->replyCount !!}]</span>
                       </p>
                    </a>
                </div>
                <div class="des clearfix">
                    <p>
                        <span><i>{!! $item->id !!}</i></span>
                        <span><i class="name">{!! $item->issuers ? $item->issuers->name : '-' !!}</i></span>
                        <span><i class="date">{!! $item->created_at !!}</i></span>
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