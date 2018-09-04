@foreach($list as $item)
    <li class="share clearfix reply-{!! $item->id !!}">
        <div class="sh-l fl">
            <i></i>
        </div>
        <div class="sh-r fr {!! $item->color !!}">
            <div class="top">
                <p class="left"><b>{{ $item->issuerName }}</b>({!! mb_substr($item->created_at, 0, 16) !!}) 211.38.***.118 </p>
                <p class="right">
                    @if($item->isDelete)
                        <a class="delete-reply" data-href="{!! route('f.reply.destroy',['id' => $item->id]) !!}" href="javascript:void(0)">
                            <i class="fa fa-trash"></i>
                        </a>
                    @endif

                    <a class="thumbs" data-href="{!! route('f.reply.thumbsUp',['id' => $item->id]) !!}"  href="javascript:void(0)">
                        <i class="fa fa-thumbs-o-up {!! $item->thumbsUpCheck ? "default" : "" !!}"></i>
                        <span class="num">{!! $item->thumbsUpCount !!}</span>
                    </a>
                    <a class="thumbs"  data-href="{!! route('f.reply.thumbsDown',['id' => $item->id]) !!}" href="javascript:void(0)">
                        <i class="fa fa-thumbs-o-down {!! $item->thumbsDownCheck ? "default" : "" !!}"></i>
                        <span class="num">{!! $item->thumbsDownCount !!}</span>
                    </a>
                    <a class="review" href="javascript:void(0)"><i class="fa fa-exclamation"></i></a>
                    <a class="reply-two-edit" data-pid="{{ $parentId }}"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" href="javascript:void(0)"> <i class="fa fa-comment-o"></i>
                    </a>
                </p>
            </div>
            <div class="con">
                <div class="img">
                    @if($item->picture)
                        @foreach($item->formatPicture as $value)
                            <img src="{!! uploads_path($value) !!}">
                        @endforeach
                    @endif
                </div>
                <p>
                    @if($item->atName)
                        <span style="color: red"> @ {{ $item->atName }}</span>
                    @endif
                    {!!  str_replace("\r\n", '<br>', e($item->contents)) !!}
                </p>
            </div>
        </div>
    </li>
@endforeach