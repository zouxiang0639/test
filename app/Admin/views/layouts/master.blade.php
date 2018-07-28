<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('admin.name'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! Admin::getCss() !!}
    @include('admin::partials.style')
    @yield('style')

</head>


<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">
<div class="wrapper">


    @include('admin::partials.header')
    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        <section class="content-header">
            @yield('content-header')
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('admin::partials.footer')

</div>


<script>
    var initial = {
        "CKEditorUploadImage": "{{ route('m.system.upload.ckeditor') }}?_method=PUT&_token=" + $('meta[name="csrf-token"]').attr('content')
    };
    var initialAjAx = {};
    $(function () {
        $('.active').parents('ul').show();
    });

</script>

@include('admin::partials.script')
{!! Admin::getJs() !!}
@yield('script')

</body>
</html>

