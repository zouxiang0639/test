@if(Admin::user()->visible($item['slug']))
    @if(!isset($item['children']))
        <li  {!! $item['route'] == Admin::getRouteName() ?'class="active"':'' !!}>
            @if(Route::has($item['route']))
                <a href="{{ route($item['route']) }}" >
            @else
                 <a href="">
            @endif
                <i class="fa {{$item['icon']}}"></i>
                <span>{{$item['title']}}</span>
            </a>
        </li>
    @else
        <li class="treeview">
            <a href="#">
                <i class="fa {{$item['icon']}}"></i>
                <span>{{$item['title']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif