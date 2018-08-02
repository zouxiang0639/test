@foreach($list as $item)
    <li class="share color-3 clearfix reply-{!! $item->id !!}">
        <div class="sh-l fl">
            <i></i>
        </div>
        <div class="sh-r fr">
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
                    <a class="reply-two-edit" data-pid="{{ $parentId }}"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" data-check="0" href="javascript:void(0)"> <i class="fa fa-comment-o"></i>
                    </a>
                </p>
            </div>
            <div class="con">
                <p>自己坐沙发 搞笑。。</p>
            </div>
        </div>
    </li>
@endforeach