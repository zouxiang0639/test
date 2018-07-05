<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('admin.name'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    @include('admin::partials.style')
    @yield('style')

</head>


<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">
<div class="wrapper">


    @include('admin::partials.header')
    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        @yield('content')
    </div>

    @include('admin::partials.footer')

</div>


<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
</script>

@include('admin::partials.script')
@yield('script')
</body>
</html>

