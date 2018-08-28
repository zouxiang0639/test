@extends('canteen::layouts.master')

@section('style')

@stop
@section('content')


    <div id="user-setting" class="page">
        <header class="bar bar-nav">
            <span class="white"></span><h1 class="page-title">评论</h1>
        </header>
        <div class="bar footer-nav">
            <a class="footer-nav-back back" href="index.html"></a>
        </div>
        <div class="content" id=''>
            <style>
                .comment-star li{
                    display: inline;
                }
                .comment-star .red{
                    color: red;
                }
            </style>
            <form action="" method="post" class="form-horizontal">
                <div class="content" id=''>
                    <form method='post' class="form-horizontal">
                        <input name="_method" type="hidden" value="PUT">
                        <input name="order_id" type="hidden" value="{!! $info->id !!}">
                        <input name="type" type="hidden" value="{!! \App\Consts\Admin\Other\FeedbackTypeConst::FEEDBACK !!}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="list-block">
                            <ul>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title label">评分</div>
                                            <div class="item-input">
                                                <ul class="comment-star">
                                                    <li data-num="1"><i class="icon icon-star"></i></li>
                                                    <li data-num="2"><i class="icon icon-star"></i></li>
                                                    <li data-num="3"><i class="icon icon-star"></i></li>
                                                    <li data-num="4"><i class="icon icon-star"></i></li>
                                                    <li data-num="5"><i class="icon icon-star"></i></li>
                                                </ul>
                                                <input type="hidden" name="num" value="">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title label">描述</div>
                                            <div class="item-input"><textarea name="contents"></textarea></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="content-block">
                            <button type="button" class="button-orange setup-post">提交</button>
                        </div>
                    </form>
                </div>
            </form>
        </div>

    </div>
@stop

@section('script')
    <script>
        $(function() {

            $('.comment-star li').click(function() {
                var num = $(this).attr('data-num');
                $('.comment-star li').removeClass('red');
                for (var i = 0; i < num; i++) {
                    $('.comment-star li').eq(i).addClass('red');
                }
                $('input[name=num]').val(num);
            });

            var locked = true;

            $('.setup-post').click(function() {
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('c.order.comment.put') !!}',
                    type: 'POST',
                    data: $('.form-horizontal').serialize(),
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {

                            var errorHtml = '';
                            var error = res.data;
                            for ( var i in error ) {
                                errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                            }
                            $.alert(errorHtml);
                            locked = true;
                        } else {
                            $.alert(res.data);
                            window.location.href = '{!! route('c.order.list') !!}';
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });

            })
        })
    </script>
@stop