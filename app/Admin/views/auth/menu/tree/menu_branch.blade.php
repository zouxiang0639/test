<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle">
        {!! $branchCallback($branch) !!}
        <span class="pull-right dd-nodrag">
            <a href="{!! route('m.menu.edit', ['id' => $branch[$keyName]]) !!}"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-url="{!! route('m.menu.destroy', ['id' => $branch[$keyName]])!!}" class="item-delete"><i class="fa fa-trash"></i></a>
        </span>
    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach($branch['children'] as $branch)
            @include($branchView, $branch)
        @endforeach
    </ol>
    @endif
</li>