<?php
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
?>

@extends('canteen::layouts.master')


@section('content')
    <div id="page-normal" class="page ground-gray" >

        <header class="bar bar-nav" style=" height: 2.72rem;padding-right: 0rem;padding-left: 0rem; ">
            <span class="icon-bought white"></span><h1 class="page-title">我的订单</h1>
            <div id="buttons-tab">
                <?php
                $type = Input::get('status');
                ?>
                <div class="buttons-tab fixed-tab"  data-offset="44" style=" height: 2.5rem;">
                    <a href="{!! route('c.order.list') !!}"  class="{!! !$type ? 'active' : ''!!} button">
                        全部订单
                    </a>
                    <a href="{!! route('c.order.list', [ 'status'=> '1']) !!}"  class="{!! $type == '1' ? 'active' : '' !!} button">
                        待交易
                    </a>
                    <a href="{!! route('c.order.list', [ 'status'=> '2']) !!}"  class="{!! $type == '2' ? 'active' : '' !!} button">待评价</a>
                    <a href="{!! route('c.order.list', [ 'status'=> '5']) !!}" class="{!! $type == '5' ? 'active' : '' !!} button">退单</a>
                </div>
            </div>
        </header>
        <div class="bar footer-nav">
            <a class="footer-nav-back" href="{!! route('c.member') !!}"></a>
        </div>
        <div class="content infinite-scroll infinite-scroll-bottom" >
            <div class="tabs">
                <div id="tab1" class="tab active" style="    font-size: .6rem;    padding-top: 2.5rem;">
                    <div class="list-container">
                    @foreach($list as $item)
                    <div class="bought-item disable">
                        <a href="javascript:;">
                            <div class="row no-gutter ui-border-b oi1">
                                <div class="col-80 oi11" style="">
                                    <p class="oi12">
                                        <b>订单日期：</b>
                                        <span>{!! $item->created_at !!}</span>
                                    </p>
                                    <p class="oi13">
                                        <strong>订单编号：</strong><span>{!! $item->id !!}</span>
                                    </p>
                                </div>
                                <div class="col-20 oi12" >
                                    <p class="oi121">{!! $item->statusName !!}</p>
                                </div>
                            </div>
                            <div class="ui-border-b oi2">
                                @if($item->type == OrderTypeConst::MEAL)
                                    @foreach($item->child as $value)
                                       <p>大于两份将从第二份开始双倍价格</p>
                                        <div class="row">
                                            <div class="col-33">{!! $value->name !!}</div>
                                            <div class="col-33">{!! $value->num !!}份</div>
                                            <div class="col-33">
                                                {!! $value->price !!}元
                                                - {!! $value->discount !!}折
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($item->child as $value)
                                        <div class="row">
                                            <div class="col-33">{!! $value->name !!}</div>
                                            <div class="col-33">{!! $value->num !!}份</div>
                                            <div class="col-33">
                                                {!! \App\Library\Format\FormatMoney::fen2yuan($value->price * $value->num) !!}元
                                            </div>
                                        </div>
                                    @endforeach

                                @endif
                            </div>
                            <div class="oi3">
                                <span>总金额 : {!! $item->formatAmount !!}元  </span>
                                <span style="padding-left: 10px">定金 :  {!! $item->formatDeposit !!}元 </span>
                                <strong>已支付{!! $item->formatPayment !!}元</strong>
                            </div>
                        </a>
                        @if($item->status == OrderStatusConst::DEPOSIT && $item->type == OrderTypeConst::TAKEOUT && config('config.takeout_deadline') >= date('Y-m-d'))
                        <div class="oi4">
                            <span style="color: #FF5722; line-height: 2rem;">每个月只能退{!! config('config.refund_limit') !!}单</span>
                            <a href="javascript:;" data-id="{!! $item->id !!}" class="org refund external">退单</a>
                        </div>
                        @endif

                        @if($item->status == OrderStatusConst::PAYMENT )
                            <div class="oi4">
                                <a href="{!! route('c.order.comment',['id' => $item->id]) !!}" class="org comment external">评论</a>
                            </div>
                        @endif
                    </div>
                    @endforeach
                    </div>
                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader">
                        <div class="preloader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="page" value="2">
@stop

@section('script')
    <script>


        $(function () {'use strict';
            var lastIndex = $('.list-container .bought-item').length;
            if(lastIndex < 20) {
                $('.infinite-scroll-preloader').hide();
            }

            var lockede = true;
            $('.refund').click(function() {
                if (! lockede) {
                    return false;
                }

                lockede = false;

                $.ajax({
                    url: '{!! route('c.order.refund') !!}',
                    type: 'POST',
                    data:{
                        "_method":"PUT",
                        "_token":$('meta[name="csrf-token"]').attr('content'),
                        "id":$(this).attr('data-id')
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {
                            $.alert(res.data);
                            lockede = true;
                        } else {
                            $.alert(res.data);
                            window.location.href =  window.location.href;
                        }
                    },
                    error:function () {
                        lockede = true;
                    }

                });
            });

            // 加载flag
            var locked = true;

            // 注册'infinite'事件处理函数
            $(document).on('infinite', '.infinite-scroll-bottom',function() {
                var page = parseInt($("input[name=page]").val());

                // 如果正在加载，则退出
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    type: 'GET',
                    data:{
                        "page":page
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {
                            $.alert(res.data);
                        }  if(res.data == ''){
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            // 删除加载提示符
                            $('.infinite-scroll-preloader').remove();
                        } else {
                            $("input[name=page]").val(page + 1 );
                            $('.infinite-scroll-bottom .list-container').append(res.data);
                            locked = true;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });


            });


            $.init();
        });


    </script>
@stop