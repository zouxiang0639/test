@extends('canteen::layouts.master')


@section('content')


    <div class="page-group">
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
                        <a href="{!! route('c.order.list', [ 'status'=> '1_2']) !!}"  class="{!! $type == '1_2' ? 'active' : '' !!} button">
                            待交易
                        </a>
                        <a href="{!! route('c.order.list', [ 'status'=> '3']) !!}"  class="{!! $type == '3' ? 'active' : '' !!} button">待评价</a>
                        <a href="{!! route('c.order.list', [ 'status'=> '5']) !!}" class="{!! $type == '5' ? 'active' : '' !!} button">退单</a>
                    </div>
                </div>
            </header>
            <div class="bar footer-nav">
                <a class="footer-nav-back" href="{!! route('c.member') !!}"></a>
            </div>
            <div class="content " >
                <div class="tabs">
                    <div id="tab1" class="tab active" style="    font-size: .6rem;    padding-top: 2.5rem;">
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
                                    @foreach($item->child as $value)
                                        <div class="row">
                                            <div class="col-33">{!! $value->name !!}</div>
                                            <div class="col-33">{!! $value->num !!}份</div>
                                            <div class="col-33">{!! \App\Library\Format\FormatMoney::fen2yuan($value->price * $value->num) !!}元</div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="oi3">
                                    <span>已付定金 :  {!! $item->formatDeposit !!}元</span><strong>总金额 : {!! $item->formatAmount !!}元</strong>
                                </div>
                            </a>
                            @if($item->status == \App\Consts\Order\OrderStatusConst::DEPOSIT)
                            <div class="oi4">
                                <span style="color: #FF5722; line-height: 2rem;">每个月只能退两单</span>
                                <a href="" class="org external">退单</a>
                            </div>
                            @endif
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')

@stop