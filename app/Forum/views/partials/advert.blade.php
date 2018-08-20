@if(!empty($advert))
    <div class="new-list">
        <ul class="clearfix">
            @foreach($advert as $item)
                <li>
                    <a href="{!! $item->links !!}"><img src="{!! uploads_path($item->picture) !!}" alt="" title="{{ $item->title }}" /></a>
                </li>
            @endforeach
        </ul>
    </div>
@endif