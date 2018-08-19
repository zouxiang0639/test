@extends('canteen::layouts.master')

@section('content')

    <div id="user-account" class="page">
        <header class="bar bar-nav">
            <span class="icon-account white"></span><h1 class="page-title">账户明细</h1>
        </header>
        <div class="bar footer-nav">
            <a class="footer-nav-back back" href="index.html"></a>
        </div>
        <div class="content">
            <div class="list-box account">
                <ul>
                    @foreach($list as $item)

                        <li class="row">
                            <span class="col-25">{!! $item->formatCreatedAt !!}</span>
                            <div class="col-75"><h2 class="color-orange">{!! $item->formatAmount !!}</h2>
                                <p>【{!! $item->typeName !!}】{!! $item->describe !!}</p></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop

@section('script')
@stop