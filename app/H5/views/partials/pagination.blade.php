@if ($paginator->hasPages())

    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">上一页</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">下一页</span></li>
        @endif
        <li class="page-jump">
             <span style="padding-left: 5px">
                 到第
                <input class="page-input" id="page" min="1" style="width: 42px;padding: 0 3px;text-align: center;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]+/,'');}).call(this)" onblur="this.v();" max="{!! $paginator->lastPage() !!}" value="{!! $paginator->currentPage() !!}"  type="text"> 页
                <a class="page-btn" type="button" page-url="{!! $paginator->url(1) !!}" onclick="
                var page = parseInt($('#page').val());
                var max = parseInt($('#page').attr('max'));
                if(page > max) {
                    page = max;
                }
                window.location.href=$(this).attr('page-url').replace('page=1', 'page=' + page)">Go</a>
            </span>
        </li>
    </ul>

@endif
