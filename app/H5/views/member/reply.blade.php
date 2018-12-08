@extends('h5::layouts.master')

@section('style')
<style>

    .com-tie {
        padding: 0.1rem;
    }
    .com-tie .top {
        height: 0.5rem;
        line-height:0.5rem;
        position: relative;
    }
    .com-tie .top .left {
        position: absolute;
        left: 0;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #666666;
    }
    .com-tie .top .right {
        position: absolute;
        right: 0;
        text-align: right;
    }
    .com-tie .top .right span {
        display: inline-block;
        vertical-align: middle;
        margin-right: 0.1rem;
        color: #999999;
        font-size: 16px;
    }
    .com-tie .con p {
        line-height: 0.4rem;
        font-size: 0.3rem;
    }
</style>
@stop
@section('content')
    @include("h5::partials.member_info")
    <div class="list-box" >
        <ul style="margin-bottom: 0px;">
            @foreach($list as $item)
                <li>
                    <div class="tit clearfix">
                        <a href="{!! route('h.article.info', ['id'=> $item->id]) !!}">
                            <i style="color:{!!  Forum::Tags()->getTagsColor($item->a_tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->a_tags) !!} icon"></i>
                            <p>{{ $item->a_title }}<span class="num">[{!! \App\Forum\Bls\Article\ReplyBls::countReply($item->a_id) !!}]</span></p>
                        </a>
                    </div>
                    <div class="des clearfix" style="background-color: aliceblue;margin-bottom: 0.2rem;">
                        <div class="com-tie">
                            <div class="top">
                                <p class="left"><b>{!! $userName !!}</b>({!! mb_substr($item->r_created_at, 0,16) !!})</p>
                                <p class="right">

                                    <span class="praise" href="javascript:void(0)">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        {!! count(\GuzzleHttp\json_decode($item->r_thumbs_up)) !!}
                                    </span>
                                    <span class="neg" href="javascript:void(0)">
                                        <i class="fa fa-thumbs-o-down"></i>
                                        {!! count(\GuzzleHttp\json_decode($item->r_thumbs_down)) !!}
                                    </span>
                                </p>
                            </div>
                            <div class="con">
                                <p>{{ $item->r_contents }}</p>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="page-box clearfix">
        {!! $list->appends(Input::get())->render() !!}
    </div>
@stop

@section('script')
<script>
    $(function(){
        var locked = true;
        //评论删除
        $(".delete-reply").on('click', function(){
            var _this = $(this);

            swal({
                        title: "确认删除?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确定",
                        closeOnConfirm: false,
                        cancelButtonText: "取消"
                    },
                    function(){

                        if (! locked) {
                            return false;
                        }

                        locked = false;
                        $.ajax({
                            url: _this.attr('data-href'),
                            type: 'POST',
                            data: {
                                "_method":"DELETE",
                                "_token":$('meta[name="csrf-token"]').attr('content')
                            },
                            cache: false,
                            dataType: 'json',
                            success:function(res) {

                                if(res.code != 0) {
                                    swal(res.data, '', 'error');
                                } else {
                                    swal(res.data, '', 'success');
                                    _this.parents('li').remove();
                                }
                                locked = true;
                            },
                            error:function () {
                                locked = true;
                            }

                        });

                    }
            );
        })
    })
</script>
@stop