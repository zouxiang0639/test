@extends('canteen::layouts.master')

@section('style')
@stop

@section('content')

    <div id="page-comesoon" class="page">
        <header class="bar bar-nav">
            <a class="footer-nav-back back" href="index.html"></a>
            <button class="button button-link button-nav pull-right">
                明天菜单
                <span class="icon icon-right"></span>
            </button>
            <h1 class="title">8月7号菜单</h1>
        </header>
        <div class="bar footer-nav">
            <div style="float: left"><p>￥ 10.00</p> </div>
            <div style="float: right"><button class="external" type="submit">订购</button></div>

        </div>
        <div class="content native-scroll takeout">
            <div class="content-block">
                <div class="buttons-row">
                    <a href="#tab1" class="tab-link active button">早餐</a>
                    <a href="#tab2" class="tab-link button">中餐</a>
                    <a href="#tab3" class="tab-link button">晚餐</a>
                </div>
            </div>
            <div class="tabs">
                <div id="tab1" class="tab active">
                    <div class="content-block">
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                    </div>
                </div>
                <div id="tab2" class="tab">
                    <div class="content-block">
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                    </div>
                </div>
                <div id="tab3" class="tab">
                    <div class="content-block">
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                        敬献白玉奶茶 <br>
                        合意饼  <br>
                        雪山梅  <br>
                        蜜饯青梅  <br>
                        焚香入宴  <br>
                        年字口蘑发菜  <br>
                        枣泥糕  <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop