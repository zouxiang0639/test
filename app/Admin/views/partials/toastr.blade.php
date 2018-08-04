@section('style')
    @parent
    <link rel="stylesheet" href="{{  assets_path("/lib/toastr/build/toastr.min.css") }}">
@stop



@section('script')
    @parent

    <script src="{{  assets_path("/lib/toastr/build/toastr.min.js") }}"></script>

    @if(Session::has('toastr'))
        @php
        $toastr     = Session::get('toastr');
        $type       = array_get($toastr->get('type'), 0, 'success');
        $message    = array_get($toastr->get('message'), 0, '');
        $options    = json_encode($toastr->get('options', []));
        @endphp
        <script>
            $(function () {
                toastr.{{$type}}('{!!  $message  !!}', null, {!! $options !!});
            });
        </script>
    @endif
@stop