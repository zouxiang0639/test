<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{!! config('config.title', '金尚美食') !!}</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <link rel="stylesheet" href="{!!  assets_path("/h5/css/sm.css")  !!}">
    <link rel="stylesheet" href="{!!  assets_path("/h5/css/swiper.min.css")  !!}">
    <link rel="stylesheet" href="{!!  assets_path("/h5/css/megalife.css")  !!}">
    <link rel="stylesheet" href="{{  assets_path("/lib/font-awesome/css/font-awesome.min.css") }}">
    <script src="{!!  assets_path("/h5/js/zepto.js")  !!}"></script>
    <script src="{!!  assets_path("/h5/js/config.js")  !!}"></script>
    @yield('style')
</head>

<body >

<div class="page-group">
    @yield('content')
    <script src="{!!  assets_path("/h5/js/sm.js")  !!}"></script>
    <script src="{!!  assets_path("/h5/js/swiper.min.js")  !!}"></script>

    @yield('script')
</div>
</body>
</html>



