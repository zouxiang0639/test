<?php
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
?>

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
</div>

@endforeach
