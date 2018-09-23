<div class="com-tie">
    <ul>
        @foreach($list as $key => $item)

            @if($key == 3)
                @include('forum::partials.reply_ad')
            @endif

            <li class="{!! $item->color !!} reply-{!! $item->id !!}">
                <div class="top">
                    <p class="left"><a href="{!! route('f.space.index', ['user_id' => $item->issuer]) !!}"><b>{{ $item->issuerName }}</b></a>({!! mb_substr($item->created_at, 0, 16) !!})
                        {{--211.38.***.118--}}
                    </p>
                    <p class="right">
                        @if($item->isDelete)
                            <a class="delete-reply" data-href="{!! route('f.reply.destroy',['id' => $item->id]) !!}" href="javascript:void(0)">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
                        <a class="thumbs" data-href="{!! route('f.reply.thumbsUp',['id' => $item->id]) !!}"  href="javascript:void(0)">
                            <i class="fa fa-thumbs-o-up {!! $item->thumbsUpCheck ? "default" : "" !!}">
                                <span class="num">{!! $item->thumbsUpCount !!}</span>
                            </i>

                        </a>
                        <a class="thumbs"  data-href="{!! route('f.reply.thumbsDown',['id' => $item->id]) !!}" href="javascript:void(0)">
                            <i class="fa fa-thumbs-o-down {!! $item->thumbsDownCheck ? "default" : "" !!}">
                                <span class="num">{!! $item->thumbsDownCount !!}</span>
                            </i>
                        </a>
                        <a class="review" href="javascript:void(0)"><i class="fa fa-exclamation"></i></a>
                        @if($item->isDelete)
                        <a class="reply-one-edit"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" href="javascript:void(0)">
                            <i class="fa fa-comment-o"></i>
                        </a>
                        @endif
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
                        {!!  str_replace("\r\n", '<br>', e($item->contents)) !!}
                    </p>
                </div>
                @if($item->childrenCount > 0)
                    <a class="other reply-show-child" data-check="0" data-id="{!! $item->id !!}" href="javascript:void(0)">回复 {!! $item->childrenCount !!}<i></i></a>
                @endif
            </li>
        @endforeach

    </ul>
</div>

<div class="page-reply">
    {!! $list->appends(Input::get())->render() !!}
</div>