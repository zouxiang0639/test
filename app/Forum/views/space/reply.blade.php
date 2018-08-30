@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
@stop

@section('content')

    @include('forum::partials.space_info')

    <div class="com-new">
        <div class="wm-850">
            @foreach($list as $item)
            <div class="new-container new-container-tie">
                <table class="new-table new-table-tie">
                    <tbody>
                    <tr>
                        <td width="55">{!! $item->r_id !!}</td>
                        <td class="l" width="515">
                            <a href="{!! route('f.article.info', ['id' => $item->a_id]) !!}">
                                <i style="color:{!!  Forum::Tags()->getTagsColor($item->a_tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->a_tags) !!}"></i>
                                {{ $item->a_title }}
                            </a>
                        </td>
                        <td width="95">{{ $item->u_name }}</td>
                        <td width="95">
                            {!! $item->a_browse !!}
                            <span class="red">{!! count(\GuzzleHttp\json_decode($item->a_recommend)) !!}</span>
                        </td>
                        <td width="90">
                            {!! mb_substr($item->a_created_at, 0, 16) !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="com-tie">
                    <ul>
                        <li class="color-1">
                            <div class="top">
                                <p class="left"><b>江南小雨</b>({!! mb_substr($item->r_created_at, 0,16) !!}) </p>
                                <p class="right">
                                    <span class="praise" href="javascript:void(0)">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        {!! count(\GuzzleHttp\json_decode($item->r_thumbs_up)) !!}
                                    </span>
                                    <span class="neg" href="javascript:void(0)">
                                        <i class="fa fa-thumbs-o-down"></i>
                                        {!! count(\GuzzleHttp\json_decode($item->r_thumbs_down)) !!}
                                    </span>

                                </p>
                            </div>
                            <div class="con">
                                <p>{{ $item->r_contents }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="com-page">
        {!! $list->appends(Input::get())->render() !!}
    </div>
@stop

@section('script')
    <script>
        $(function(){
            var locked = true;
            //评论删除
            $(".delete-reply").on('click', function(){
                var _this = $(this);

                swal({
                            title: "确认删除?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "确定",
                            closeOnConfirm: false,
                            cancelButtonText: "取消"
                        },
                        function(){

                            if (! locked) {
                                return false;
                            }

                            locked = false;
                            $.ajax({
                                url: _this.attr('data-href'),
                                type: 'POST',
                                data: {
                                    "_method":"DELETE",
                                    "_token":$('meta[name="csrf-token"]').attr('content')
                                },
                                cache: false,
                                dataType: 'json',
                                success:function(res) {

                                    if(res.code != 0) {
                                        swal(res.data, '', 'error');
                                    } else {
                                        swal(res.data, '', 'success');
                                        _this.parents('.new-container-tie').remove();
                                    }
                                    locked = true;
                                },
                                error:function () {
                                    locked = true;
                                }

                            });

                        }
                );
            })
        })
    </script>
@stop