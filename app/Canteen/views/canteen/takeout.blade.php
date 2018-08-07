@extends('canteen::layouts.master')

@section('style')
<style>
    .item-subtitle p{
        line-height: 1px;
    }
    .item-subtitle .takeout-describe{
        line-height: 3px;
        font-size: 12px;
        color: #7e7e7e;
    }

    .item-subtitle .takeout-click{
        font-size: 1.5em;
    }
    .item-subtitle .minus{
        color: #b6b0a7;
    }
    .item-subtitle .plus{
        color: #e8a952;
    }
    .cart{
        color: #ffffff;
        width: 2rem;
        height: 2rem;
        line-height: 2rem;
        border-radius: 50%;
        text-align: center;
        background: #ff7d7c;
        position: absolute;
        margin-top: 0.25rem;
    }
    .badge {
        margin-left: 2rem;
        color:#d83e3d;
    }

    @media screen and (min-width:320px) {

        .takeout .cart {
        }
    }
</style>
@stop

@section('content')
    <div class="page-group">

        <div id="page-comesoon" class="page">
            <header class="bar bar-nav">
                <a class="footer-nav-back back" href="index.html"></a>
                <h1 class="page-title">本周外卖</h1>
            </header>
            <div class="bar footer-nav">

                <div  style="float: left">
                    <div class="cart">
                        <span><i class="fa fa-shopping-cart"></i></span>

                    </div>
                    <span class="badge">2</span>
                </div>
                <div style="float: left"><p style="padding-left: 2rem;">￥ 70.00</p> </div>
                <div style="float: right"><button class="external" type="submit">订购</button></div>

            </div>
            <div class="content native-scroll takeout">
                <div class="list-block media-list">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><img src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" style='width: 4rem;'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">包子</div>
                                    </div>
                                    <div class="item-subtitle">
                                        <p class="takeout-describe">这里是描述</p>
                                        <div>
                                            <div class="takeout-price" style="float: left">
                                                库存<span style="color: red">1</span>份
                                                <span style="color: red">￥10</span> /份
                                            </div>
                                            <div class="takeout-click" style="float: right">
                                                <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                                <span>1</span>
                                                <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop