<div id="all_article">
    <ul class="pagination" style="display: none">
        <li><a href="{!! route('f.article.all') !!}">2</a></li>
    </ul>
</div>

@section('script')
    @parent
<script>
    var locked = true;
    //异步加载回复子数据
    $("#all_article").on('click', '.pagination a', function(){
        var parentId = $(this).attr('data-id');
        if (! locked) {
            return false;
        }

        locked = false;

        $.ajax({
            url: $(this).attr('href'),
            type: 'PUT',
            data: {
                "_method": "PUT",
                'parent_id' : parentId,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code != 0) {
                    $('.page').html(res.data);
                } else {
                    $('#all_article').html(res.data);
                    locked = true;
                }
            },
            error:function () {
                locked = true;
            }

        });
        return false;
    });

    $('.pagination a').trigger('click');
</script>
@stop