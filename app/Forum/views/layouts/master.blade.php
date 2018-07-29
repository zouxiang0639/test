<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>板块列表</title>
    <link rel="stylesheet" href="{!! assets_path("/forum/css/common.css") !!}" />
    @yield('style')
</head>
<body>

    @include('forum::partials.header')

    @yield('content')

    @include('forum::partials.footer')

</body>
</html>
