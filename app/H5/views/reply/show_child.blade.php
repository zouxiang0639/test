<li class="share reply-show  clearfixs child-{!! $parentId !!}">
    <ul>
        @foreach($list as $item)
            <li class="share clearfix reply-{!! $item->id !!}">

                <div class="relpy-bz fl"><i></i></div>
                <div class="box box-d fl {!! $item->color !!}" style="float: right;">
                    <div class="con-1 clearfix">
                        <p class="fl">
                            @if(!empty($item->issuerName))
                                <a href="{!! route('h.space.index', ['user_id' => $item->issuer]) !!}"><b>{{ $item->issuerName }}</b></a>
                            @else
                                匿名
                            @endif
                           ({!! mb_substr($item->created_at, 0, 16) !!})
                            {{--211.38.***.118--}}
                        </p>
                        <p class="fr">
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
                            <a class="review check-auth" href="{!! route('f.feedback.reply', ['reply_id' => $item->id]) !!}"><i class="fa fa-exclamation"></i></a>
                            @if(is_null($item->deleted_at))
                                <a class="reply-one-edit"  data-id="{{ $item->id }}" data-at="{{ $item->issuer }}" href="javascript:void(0)">
                                    <i class="fa fa-comment-o"></i>
                                </a>
                            @endif
                        </p>
                    </div>
                    <div class="con-2">
                        <div class="img">
                            @if($item->picture)
                                @foreach($item->formatPicture as $value)
                                    <img src="{!! uploads_path($value) !!}">
                                @endforeach
                            @endif
                        </div>
                        <p {!! !is_null($item->deleted_at) ? 'style="color: #999999"' : '' !!} >
                            {!!  str_replace("\r\n", '<br>', e($item->contents)) !!}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</li>

