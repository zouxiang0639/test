@foreach($list as $item)
    <li class="row">
        <span class="col-25">{!! $item->formatCreatedAt !!}</span>
        <div class="col-75"><h2 class="color-orange">{!! $item->formatAmount !!}</h2>
            <p>【{!! $item->typeName !!}】{!! $item->describe !!}</p></div>
    </li>
@endforeach