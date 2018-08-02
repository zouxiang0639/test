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
            <td width="55">11</td>
            <td class="l" width="515">
                <a href="{!! route('f.article.info', ['id' => $item->id]) !!}">
                    <i class="i-1"></i>
                    {{ $item->title }}
                </a>
            </td>
            <td width="95">清歌莫断肠</td>
            <td width="95">
                537533
                <span class="red">2445</span>
            </td>
            <td width="90">
                2018/5/1<br />
                16:00
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="com-page">
    {!! $list->render() !!}
</div>