@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
@stop

@section('content')
    <div class="list-container">
        <div class="wm-850">
            <div class="list">
                <div class="list-txt">
                    <p style="color: #cccccc;line-height:20px;">这里是幽默板块</p>
                    <p style="color: #cccccc;line-height:20px;">您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容</p>
                    <p style="color: #cccccc;line-height:20px;">其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块</p>
                </div>
                <div class="list-other">
                    点击查看幽默板块→
                    <a href="javascript:void(0)">热门</a>
                    <a href="javascript:void(0)">最新</a>
                </div>
            </div>
        </div>
    </div>
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container">
                <div class="new-tit"><i></i></div>
                <table class="new-table">
                    <thead>
                    <tr>
                        <th width="55">编号</th>
                        <th width="515">题目</th>
                        <th width="95">ID</th>
                        <th width="95">浏览/推荐</th>
                        <th width="90">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td width="55"> {{ $item->id }}</td>
                            <td class="l" width="515">
                                <a href="{!! route('f.article.info', ['id' => $item->id]) !!}">
                                    <i class="i-1"></i>
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td width="95">清歌莫断肠</td>
                            <td width="95">
                                {{ $item->browse }}
                                <span class="red"> {{ count($item->recommend) }}</span>
                            </td>
                            <td width="90">
                               {!! mb_substr($item->created_at, 0, 16) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="com-page">
                    {!! $list->appends(Input::get())->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop