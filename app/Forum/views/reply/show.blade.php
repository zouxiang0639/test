@foreach($list as $item)
    <li class="color-5 reply-{!! $item->id !!}"">
        <div class="top">
            <p class="left"><b>{{ $item->issuerName }}</b>({!! mb_substr($item->created_at, 0, 16) !!}) 211.38.***.118 </p>
            <p class="right">
                <a class="delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
                <a class="thumbs" data-href="{!! route('f.reply.thumbsUp',['id' => $item->id]) !!}"  href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-up {!! $item->thumbsUpCheck ? "default" : "" !!}"></i>
                    <span class="num">{!! $item->thumbsUpCount !!}</span>
                </a>
                <a class="thumbs"  data-href="{!! route('f.reply.thumbsDown',['id' => $item->id]) !!}" href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-down {!! $item->thumbsDownCheck ? "default" : "" !!}"></i>
                    <span class="num">{!! $item->thumbsDownCount !!}</span>
                </a>
                <a class="review" href="javascript:void(0)"><i class="fa fa-exclamation"></i></a>
                <a class="reply-one-edit"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" check="0" href="javascript:void(0)">
                    <i class="fa fa-comment-o"></i>
                </a>
            </p>
        </div>
        <div class="con">
            <p>{{ $item->contents }}</p>
        </div>
        @if($item->childrenCount > 0)
            <a class="other reply-show-child" data-id="{!! $item->id !!}" href="javascript:void(0)">回复 {!! $item->childrenCount !!}<i></i></a>
        @endif
    </li>

    @if($item->childrenCount > 0)
        <li class="share clearfixs ">
            <ul class="child-{!! $item->id !!}">
                @include('forum::reply.show_child', ['list' => $item->children, 'parentId'=>$item->id])
            </ul>
        </li>
    @endif
@endforeach