<div class="my-info">
    <div class="option clearfix">
        <a class="edit" href="{!! route('h.member.setup') !!}">
            <i class="fa fa-pencil-square-o"></i>
        </a>
        <a class="right sign-in" href="javascript:void(0)">
            <i {!! mb_substr($info->sign_time, 0, 10) ==  date('Y-m-d') ? 'style="color:#f0f191"' : '' !!} class="fa fa-check-square-o">
            </i>
        </a>
        <a class="right" style="float: right;" href="{!! route('h.auth.logout') !!}">
            <i class="fa fa-sign-out">
            </i>
        </a>
    </div>
    <div class="my-tit">
        <p>{{ $info->name }}</p>
    </div>
    <div class="my-des">
        <ul class="clearfix">
            <li>
                收到赞数：{!! $info->thumbs_up ?: 0 !!} &nbsp;{!! $info->thumbs_down !!}
            </li>
            <li>
                注册时间：{!! mb_substr($info->created_at, 0, 10) !!}
            </li>
            <li>
                登陆次数：{!! $info->login_num !!}
            </li>
            <li>
             <i style="cursor:pointer;color: #fefd95;" class="integral-click">？</i>&nbsp;积分：<span id="integral" data-num='{!! $info->integral !!}'>{!! $info->integral ?: 0 !!}</span>
                <div class="integral-contents" style="display: none">
                    {!!  Forum::fragment()->get(5, 'contents') !!}
                </div>

            </li>
        </ul>
    </div>
</div>

<div class="my-state">
    <ul class="clearfix">
        <li>
            <a href="{!! route('h.member.index') !!}">
                发帖
                <span class="num">{!! $articleCount !!}</span>
                {!! $current == 1 ? '<i class="ico icon-arrow"></i>' : '' !!}
            </a>
        </li>
        <li>
            <a href="{!! route('h.member.reply') !!}">
                回复
                <span class="num">{!! $replyCount !!}</span>
                {!! $current == 2 ? '<i class="ico icon-arrow"></i>' : '' !!}
            </a>
        </li>
        <li>
            <a href="{!! route('h.member.star') !!}">
                收藏
                <span class="num">{!! $articlesStarCount !!}</span>
                {!! $current == 4 ? '<i class="ico icon-arrow"></i>' : '' !!}
            </a>
        </li>
        <li>
            <a href="{!! route('h.member.info') !!}">
                消息
                <span class="num">{!! $infoCount !!}</span>
                {!! $current == 5 ? '<i class="ico icon-arrow"></i>' : '' !!}
            </a>
        </li>
    </ul>
</div>

<div class="modal fade bs-example-modal-lg" id="integral-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close blue" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title blue">积分描述</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    {!!  Forum::fragment()->get(5, 'contents') !!}
                </div>
            </div>

        </div>
    </div>
</div>

@section('script')
    @parent
    <script>
        $(function(){
            var locked = true;
            $('.sign-in').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: "{!! route('f.member.sign.in') !!}",
                    type: 'POST',
                    data: {
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            $('.sign-in i').css({color:"#f0f191"});
                            $('#integral').text(parseInt($('#integral').attr('data-num')) + 5);
                            locked = true;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });
            });
            $('.integral-click').click(function(){
                swal({
                    title: "<h4>积分描述</h4>",
                    text: $('.integral-contents').html(),
                    html: true
                });
            })
        })
    </script>
@stop