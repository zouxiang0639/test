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
        <tr class="@if(in_array($item->id,session('article', []))) read @endif">
            <td width="55"> {{ $item->id }}</td>
            <td class="l" width="515">
                <?php
                $pageArray =  isset($page) ? ['page' =>  $page] : [];
                ?>
                <a href="{!! route('f.article.info', array_merge(['id' => $item->id], $pageArray)) !!}">
                    <i style="color:{!!  Forum::Tags()->getTagsColor($item->tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->tags) !!}"></i>
                    {{ $item->title }} <span style="color: #00a7d0">[{!! $item->replyCount !!}]</span>
                </a>
            </td>
            <td width="95">
                @if($item->tags == 4 && $item->is_hide == \App\Consts\Common\WhetherConst::YES)
                    匿名
                @else
                    {!! $item->issuers ? $item->issuers->name : '-' !!}
                @endif
            </td>
            <td width="95">
                {{ $item->browse }}
                <span class="red"> {{ $item->recommend_count }}</span>
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