<?php
use App\Consts\Common\SearchType;
?>

@extends('h5::layouts.master')

@section('style')
<style>
    .search {

        border: 1px solid #2c56a5;
        background: #31465b;
        margin: 0 auto;
    }
    .search .s-txt {

        float: left;
        width: 220px;
        padding-left: 10px;
        height: 28px;
        background: #364559;;
        color: #fff;

    }
    .search .s-btn {

        float: right;
        margin: 5px 7px 0 0;
        font-size: 19px;
        color: #F0F182;

    }
    .select{
        cursor: pointer;
        border: 1px solid #1a3148;
        margin: 5px 0 0px 10px;
        padding-right: 2px;
        float: left;
        background: #31465b;
    }
</style>
@stop
@section('content')
    <div class="list-menu">

        <div class="search clearfix">
            <form id="search-form" action="{!! route('h.article.search') !!}">

                {!! Form::select('type_key', SearchType::desc(), Input::get('type_key'), ['class'=>'select']) !!}



                <input style="width: 159px" class="s-txt" type="text" name="key" placeholder="{!! Input::get('key') !!}" />
                <a class="s-btn icon-search" id="search-submit" href="javascript:void(0)"></a>

            </form>
        </div>
    </div>

    @include('h5::article.article_list')
@stop

@section('script')
    <script>
        $(function() {
            $('#search-submit').click(function() {
                var key = $('.search input[name=key]').val();
                if(key == '') {
                    swal("请输入关键字", '', 'error');
                    return false;
                }
                document.getElementById("search-form").submit();
            })
        })
    </script>
@stop