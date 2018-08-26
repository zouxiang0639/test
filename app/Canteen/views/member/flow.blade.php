@extends('canteen::layouts.master')

@section('content')

    <div id="user-account" class="page">
        <header class="bar bar-nav">
            <span class="icon-account white"></span><h1 class="page-title">账户明细</h1>
        </header>
        <div class="bar footer-nav">
            <a class="footer-nav-back back" href="index.html"></a>
        </div>
        <!-- 添加 class infinite-scroll 和 data-distance  向下无限滚动可不加infinite-scroll-bottom类，这里加上是为了和下面的向上无限滚动区分-->
        <div class="content infinite-scroll infinite-scroll-bottom" data-distance="100">
            <div class="list-box account">
                <ul class="list-container">
                    @foreach($list as $item)

                        <li class="row">
                            <span class="col-25">{!! $item->formatCreatedAt !!}</span>
                            <div class="col-75"><h2 class="color-orange">{!! $item->formatAmount !!}</h2>
                                <p>【{!! $item->typeName !!}】{!! $item->describe !!}</p></div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 加载提示符 -->
            <div class="infinite-scroll-preloader">
                <div class="preloader"></div>
            </div>
        </div>
    </div>
    <input type="hidden" name="page" value="2">
@stop

@section('script')
    <script>
        $(function () {'use strict';

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