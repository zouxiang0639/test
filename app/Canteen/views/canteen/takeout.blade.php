@extends('canteen::layouts.master')

@section('style')
<style>

    .takeout-click .minus, .takeout-click .plus{
        cursor:pointer;
    }
    .takeout-click .minus,.takeout-click .num{
        display: none;
    }
    .b1{line-height: 0.40rem;background: #fff;position: relative; margin: 1rem 0rem;padding-left: 1rem;}
</style>
@stop

@section('content')


    <div id="page-comesoon" class="page takeout">
        <header class="bar bar-nav">
            <a class="footer-nav-back back" href="index.html"></a>
            <h1 class="page-title">本周外卖</h1>
        </header>
        <div class="bar footer-nav">

            <div  style="float: left">
                <div class="cart takeout-buy">
                    <span><i class="fa fa-shopping-cart"></i></span>

                </div>
                <span class="badge">0</span>
            </div>
            <div style="float: left"><p style="padding-left: 2rem;color: red">￥ <span class="amount">0.00</span> </p> </div>
            <div style="float: right"><button class="external takeout-buy" @if(!$takeoutDeadlineCheck)style="background-color: #848484;" @endif>订购</button></div>

        </div>
        <div class="content native-scroll takeout">
            <div class="content-block-title">
                外卖截止日期
                <span style="color: red">
                    {!! config('config.takeout_deadline') !!}
                </span>
            </div>
            <div class="list-block media-list">
                <ul>
                    @foreach($list as $item)
                    <li>
                        <div class="item-content">
                            <div class="item-media"><img src="{!! $item->picture !!}" style='width: 4rem;'></div>
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">{!! $item->title !!}</div>
                                </div>
                                <div class="item-subtitle">
                                    <p class="takeout-describe">{!! $item->describe !!}</p>
                                    <p class="takeout-describe">每人限购<span style="color: red">{!! $item->limit !!}</span>份</p>
                                    <div>
                                        <div class="takeout-price" style="float: left">
                                            库存<span style="color: red">{!! $item->stock !!}</span>份
                                            <span style="color: red">￥{!! $item->formatPrice !!}</span> /份
                                        </div>
                                        <div class="takeout-click" style="float: right">
                                            <span class="minus" data-id="{!! $item->id !!}" ><i class="fa fa-minus-circle"></i></span>
                                            <span class="num">1</span>
                                            <span class="plus" data-id="{!! $item->id !!}"><i class="fa fa-plus-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <input name="takeout" type="hidden" value='{!! $json !!}'>
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

                    </ul>
                </div>

                <div class="content-block">

                </div>
                <div id="tab1" class="tab active">
                    <div class="item-inner b1" style="">
                        <p>总金额：<span style="color: red" class="buy-amount">0.00</span>元</p>
                        <p>定金：<span  style="color: red" class="buy-deposit">0.00</span>元</p>
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
            var takeout = JSON.parse($('input[name=takeout]').val());
            var num = 0;
            var amount = 0;
            var deposit = 0;
            var data = new Array();
            var locked = true;
            var takeoutDeadlineCheck = '{!! $takeoutDeadlineCheck ? 1 : 0 !!}';

            //我的购物车
            $('.takeout-buy').click(function() {
                var html = '';
                console.log(takeoutDeadlineCheck);
                if(takeoutDeadlineCheck == 0) {
                    $.alert('外卖订购已结束');
                    return false;
                }

                if(num == 0) {
                    $.alert('请选择外卖');
                    return false;
                }

                data.length = 0;
                for(var p in takeout){

                    if(takeout[p].num < 1) {
                        continue;
                    }
                    var price = fmoney((takeout[p].price /100) * takeout[p].num);
                    data.push(takeout[p]);
                    html += '<li class="item-content">' +
                            '<div class="item-inner">' +
                            '<div class="item-title">' + takeout[p].title + '</div>' +
                            '<div class="item-title"><span style="color: red">' + takeout[p].num + '</span>份</div>' +
                            '<div class="item-after"><span style="color: red">' + price + '</span>元</div> ' +
                            '</div>' +
                            '</li>';
                }

                $('.takeout-buy-content').html(html);
                $('.buy-amount').text(fmoney(amount));
                $('.buy-deposit').text(fmoney(deposit));
                $.popup('.takeout-buy-services');
            });


            //订购
            $('.takeout-buy-submit').click(function(){

                $.confirm('总金额' + fmoney(amount) + '元', '支付定金' + fmoney(deposit) + '元', function () {
                    if (! locked) {
                        return false;
                    }

                    locked = false;

                    $.ajax({
                        url: '{!! route('c.canteen.takeout.buy') !!}',
                        type: 'POST',
                        data: {
                            "_method":"PUT",
                            "_token":$('meta[name="csrf-token"]').attr('content'),
                            "data": data
                        },
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
            });

            //加
            $('.plus').click(function(){
                var id = $(this).attr('data-id');
                var obj = takeout[id];
                if(obj.num >= obj.limit) {
                    $.alert('每人限购' + obj.limit + '份');
                    return false;
                }else if(obj.num >= obj.stock){
                    $.alert('库存不够');
                    return false;
                } else {

                    obj.num ++;
                    num ++;
                    amount += obj.price/100;
                    deposit += obj.deposit/100;
                }


                if(obj.num > 0) {
                    $(this).siblings('.minus').show();
                    $(this).siblings('.num').show();
                }

                $(this).siblings('.num').text(obj.num);
                $('.badge').text(num);
                $('.amount').text(fmoney(amount));
            });

            //减
            $('.minus').click(function(){
                var id = $(this).attr('data-id');
                var obj = takeout[id];
                if(obj.num > 0) {
                    obj.num --;
                    num --;
                    amount -= obj.price/100;
                    deposit -= obj.deposit/100;
                }

                if(obj.num == 0) {
                    $(this).hide();
                    $(this).siblings('.num').hide();
                }

                $(this).siblings('.num').text(obj.num);
                $('.badge').text(num);
                $('.amount').text(fmoney(amount));
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