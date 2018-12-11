<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="auth—num" content="{{ Auth::guard('forum')->id() }}" />
    <title>{!! config('config.title', '空地社区') !!}@yield('title')</title>
    <meta name='keywords' content="{!! config('config.keywords', '空地社区') !!}" />
    <meta name='description' content="{!! config('config.description', '空地社区') !!}" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @if(config('config.ico'))
        <link href="{!! uploads_path(config('config.ico')) !!}" type="image/x-icon" rel="shortcut icon">
    @endif
    <link rel="stylesheet" href="{{  assets_path("/h5/css/base.css") }}" />
    <link rel="stylesheet" href="{{  assets_path("/h5/css/swiper.min.css") }}" />
    <script type="text/javascript" src="{{  assets_path("/h5/js/lib-flexible.js") }}" ></script>
    <link rel="stylesheet" href="{{  assets_path("/lib/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{  assets_path("/lib/icomoon/style.css") }}">
    <link rel="stylesheet" href="{{  assets_path("/lib/sweetalert/dist/sweetalert.css") }}">
    <link rel="stylesheet" href="{!! assets_path("/lib/bootstrap3/bootstrap.min.css") !!}" />


    @yield('style')
</head>
<body>
@include('h5::partials.header')

@yield('content')

@include('h5::partials.footer')

<script type="text/javascript" src="{{  assets_path("/h5/js/jquery.min.js") }}" ></script>
<script type="text/javascript" src="{{  assets_path("/h5/js/swiper.min.js") }}" ></script>
<script src="{{  assets_path("/lib/sweetalert/dist/sweetalert.min.js") }}"></script>
@yield('script')
<script type="text/javascript">
    $(function() {
        //底部的回到顶部
        $("#scroll_top").on("click", function() {
            $("body,html").animate({scrollTop: '0'}, 800);
        });
    });
</script>
</body>
</html>
