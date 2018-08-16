@extends('canteen::layouts.master')

@section('style')
    <style>
        .meal-click .minus, .meal-click .plus{
            cursor:pointer;
        }
        .b1{line-height: 0.40rem;background: #fff;position: relative; margin: 1rem 0rem;padding-left: 1rem;}
    </style>
@stop

@section('content')

    <div id="page-comesoon" class="page">
        <header class="bar bar-nav">
            <a class="footer-nav-back " href="{!! route('c.member') !!}"></a>

            <h1 class="page-title">{!! $date !!}菜单</h1>
        </header>

        <div class="bar footer-nav">
            <a class="footer-nav-back" href="{!! route('c.member') !!}"></a>
            @if(in_array($date, $checkMenu))
            <div style="float: left">
                <p style="padding-left: 2rem;color: red">￥ <span class="amount">0.00</span> </p>
            </div>
                <div style="float: right">
                    <button class="external takeout-buy" @if(!$check || $checkOverdue)style="background-color: #848484;" @endif>订购<span class="meal-type-name">早餐</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="content native-scroll takeout">

            <div class="content-block">
                <p class="buttons-row"> 预定截止时间
                <span style="color: red">
                    {!! config('config.meal_deadline') !!} : 00
                </span>
                    点</p>
                <p class="buttons-row"> 每周违约
                <span style="color: red">
                    {!! config('config.meal_overdue_num') !!}
                </span>
                    次将不能预约, <span style="padding-left: 5px">你已违约{!! $overdue !!}次</span></p>
                <p class="buttons-row">
                    @foreach($menu as $key => $value)
                        <a href="{!! route('c.canteen.meal', ['date' => $value]) !!}" class="button button-round {!! $value == $date ? 'active' : ''!!}">
                            {!! $key !!}
                        </a>
                    @endforeach
                </p>
                <div class="buttons-row menu">
                    <a href="#tab1" data-type="{!! \App\Consts\Common\MealTypeConst::MORNING !!}" class="tab-link active button">早餐</a>
                    <a href="#tab2" data-type="{!! \App\Consts\Common\MealTypeConst::LUNCH !!}" class="tab-link button">中餐</a>
                    <a href="#tab3" data-type="{!! \App\Consts\Common\MealTypeConst::DINNER !!}"  class="tab-link button">晚餐</a>
                </div>
            </div>
            <div class="tabs">
                <div id="tab1" class="tab active">
                    <div class="content-block">
                       {!! $info ? str_replace("\r\n", '<br>', $info->morning) : '没有设置早餐' !!}
                    </div>
                </div>
                <div id="tab2" class="tab">
                    <div class="content-block">
                        {!! $info ? str_replace("\r\n", '<br>', $info->lunch) : '没有设置午餐' !!}
                    </div>
                </div>
                <div id="tab3" class="tab">
                    <div class="content-block">
                        {!! $info ? str_replace("\r\n", '<br>', $info->dinner) : '没有设置晚餐' !!}
                    </div>
                </div>
            </div>
        </div>
        <input name="data" type="hidden" value='{!! $data !!}'>
    </div>
    <div class="popup takeout-buy-services">
        <div class="content-block">
            <header class="bar bar-nav">
                <a class="footer-nav-back close-popup" href="javascript:;"></a>
                <h1 class="page-title">我的购物车</h1>
            </header>
            <p><a href="#" class="close-popup">Close popup</a></p>
            <div class="content">
                <div class="list-block">
                    <ul class="takeout-buy-content">
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title meal-name">早餐</div>
                                <div class="item-title"><span class="meal-price" style="color: red"></span>元</div>
                                <div class="item-after meal-click item-subtitle">
                                    <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                    <span class="num">1</span>
                                    <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                </div>

                                </div>
                            </li>
                    </ul>
                </div>

                <div class="content-block">

                </div>
                <div id="tab1" class="tab active">
                    <div class="item-inner b1" style="">
                        <p>大于两份将从第二份开始双倍价格</p>
                        <p>价格：<span  style="color: red" class="amount">0.00</span>元</p>
                        <p>折扣：<span  style="color: red" class="meal-discount"></span>折</p>
                        <p>定金：<span  style="color: red" class="buy-deposit">{!! $deposit !!}</span>元</p>
                    </div>
                </div>
            </div>

            <div class="bar footer-nav">

                <a class="footer-nav-back close-popup" href="javascript:;"></a>

                <div style="float: right"><button class="external takeout-buy-submit" >支付</button></div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            var meal = JSON.parse($('input[name=data]').val());
            var data = {
                "type" : 0,
                "num" : 1,
                "amount" : 0,
                "deposit" : 0,
                "price" : 0,
                "discount" : 0,
                "date" : '{!! $date !!}',
                "recipes_id" : '{!! $info ? $info->id : '' !!}',
                "_method":"PUT",
                "_token":$('meta[name="csrf-token"]').attr('content')
            };
            var price = 0;

            var locked = true;
            var check = '{!! $check !!}';
            var checkOverdue = '{!! $checkOverdue !!}';

            $('.menu a').click(function() {

                data.type = $(this).attr('data-type');
                data.price = parseInt(meal.price[data.type]);
                data.discount = parseInt(meal.discount[check]) / 100;

                $('.meal-discount').text(meal.discount[check]);
                $('.meal-type-name').text(meal.type[data.type]);
                $('.amount').text(fmoney(data.price / 100));

            });

            $('.menu a').eq(0).trigger('click');

            //我的购物车
            $('.takeout-buy').click(function() {

                if(checkOverdue == 1) {
                    $.alert('你已违约超过次数,本周不可以订购');
                    return false;
                }

                if(check == 0) {
                    $.alert('订购时间已截止');
                    return false;
                }

                $('.meal-name').text(meal.type[data.type]);

                data.amount = (((data.num - 1) * (data.price * 2)) + data.price) * data.discount;
                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);

                $.popup('.takeout-buy-services');
            });


            //订购
            $('.takeout-buy-submit').click(function(){

                if(data.num < 1) {
                    $.alert('请选择数量');
                    return false;
                }

                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('c.canteen.meal.buy') !!}',
                    type: 'POST',
                    data:data,
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {
                            $.alert(res.data);
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

            });

            //加
            $('.plus').click(function(){
                data.num ++;

                if(data.num > 0) {
                    $(this).siblings('.minus').show();
                    $(this).siblings('.num').show();
                }

                if(data.num == 1) {
                    data.amount += data.price  * data.discount;
                } else {
                    data.amount += (data.price * 2)  * data.discount;
                }


                if(data.num > 0) {
                    $(this).siblings('.minus').show();
                    $(this).siblings('.num').show();
                }


                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);
            });

            //减
            $('.minus').click(function(){

                data.num --;

                if(data.num == 0) {
                    data.amount -= data.price * data.discount;
                } else {
                    data.amount -= (data.price * 2) * data.discount;
                }

                if(data.num == 0) {
                    $(this).hide();
                    $(this).siblings('.num').hide();
                }

                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);
            });
        });

        //格式化金额千分位
        function fmoney(s, n) {
            n = n > 0 && n <= 20 ? n : 2;
            s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
            var l = s.split(".")[0].split("").reverse(),
                    r = s.split(".")[1];
            t = "";
            for(i = 0; i < l.length; i ++ )
            {
                t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
            }
            return t.split("").reverse().join("") + "." + r;
        }

        //还原千分位
        function rmoney(s) {
            return parseFloat(s.replace(/[^\d\.-]/g, ""));
        }
    </script>
@stop