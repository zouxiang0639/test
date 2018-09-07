<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="auth—num" content="{{ Auth::guard('forum')->id() }}" />
    <title>{!! config('config.title', '空地社区') !!}</title>
    <meta name='keywords' content="{!! config('config.keywords', '空地社区') !!}" />
    <meta name='description' content="{!! config('config.description', '空地社区') !!}" />
    <script src="{{  assets_path("/forum/js/jQuery-2.1.4.min.js") }}"></script>

    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
    <link rel="stylesheet" href="{!! assets_path("/lib/bootstrap3/bootstrap.min.css") !!}" />
    <script src="{{  assets_path("/lib/bootstrap3/bootstrap.min.js") }}"></script>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/login.css") !!}" />
    <link rel="stylesheet" href="{{  assets_path("/lib/sweetalert/dist/sweetalert.css") }}">
    <link rel="stylesheet" href="{{  assets_path("/lib/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{  assets_path("/lib/icomoon/style.css") }}">
    @yield('style')
</head>
<body>

    @include('forum::partials.header')

    @yield('content')

    @include('forum::partials.footer')
    @include('forum::partials.auth')
    <script src="{{  assets_path("/forum/js/common.js") }}"></script>
    <script src="{{  assets_path("/lib/sweetalert/dist/sweetalert.min.js") }}"></script>
    @yield('script')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>
