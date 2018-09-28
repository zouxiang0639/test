<li class="share clearfixs child-{!! Input::get('parent_id') !!}">
    <ul>
        @foreach($list as $item)
            <li class="share clearfix reply-{!! $item->id !!}">
                <div class="sh-l fl">
                    <i></i>
                </div>
                <div class="sh-r fr {!! $item->color !!}">
                    <div class="top">
                        <p class="left">
                            <a href="{!! route('f.space.index', ['user_id' => $item->issuer]) !!}" style="color: #666666;">
                                <b>{{ $item->issuerName }}</b>
                            </a>
                            ({!! mb_substr($item->created_at, 0, 16) !!})
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

                            @if(is_null($item->deleted_at))
                                <a class="reply-two-edit" data-pid="{{ Input::get('parent_id') }}"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" href="javascript:void(0)"> <i class="fa fa-comment-o"></i>
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
                        <p {!! !is_null($item->deleted_at) ? 'style="color: #999999"' : '' !!} >
                            @if($item->atName)
                                <b style="color: #666666">  {{ '@'.$item->atName }}</b>
                            @endif
                            {!!  str_replace("\r\n", '<br>', e($item->contents)) !!}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</li>
