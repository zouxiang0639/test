@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
@stop

@section('content-header')
    <h1>
         评论<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline" name="search" action="">
                    <div class="input-group input-group-sm ">
                        <div class="box box-body  box-solid box-default no-margin" style="padding: 4px 10px">
                            {!! Form::checkbox('recycle', 1, Input::get('recycle')) !!} 回收站
                        </div>
                    </div>
                    <div class="input-group input-group-sm" style="width: 200px">
                        {!! Form::select2BySearch(route('m.customer.users.search'), 'issuer', $userList, Input::get('issuer'), ['class'=>'form-control','placeholder'=>'全部']) !!}
                    </div>
                    <div class="input-group input-group-sm ">
                        {!! Form::text('article_id', Input::get('article_id'), ['class'=>'form-control','placeholder'=>'文章编号']) !!}
                    </div>
                    <div class="input-group input-group-sm" >
                        {!! Form::text('contents', Input::get('contents'), ['class'=>'form-control','placeholder'=>'内容查询']) !!}
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                </form>

            </div>

            <div class="pull-right">

            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th width="60">编号</th>
                    <th width="100">文章id</th>
                    <th width="100">图片</th>
                    <th width="100">发表人</th>
                    <th>内容</th>
                    <th>发表时间</th>
                    <th width="170">操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td><a target="_blank" href="{!! route('f.article.info', ['id' => $item->article_id]) !!}">{{ $item->article_id }}</a></td>
                        <td>
                            @foreach($item->pictureFormat as $value)
                                <a target="_blank" href="{!! uploads_path($value) !!}">
                                    <img width="50" src="{!! uploads_path($value) !!}">
                                </a>

                            @endforeach
                        </td>
                        <td>{{ $item->issuerName }}</td>
                            <td>{{ mb_substr($item->contents,0,100,'utf-8') }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="collapse" data-target=".trace-{{ $item->id }}">
                                详情
                                </button>
                                @if(Input::get('recycle'))
                                    <button class="btn  btn-warning item-reduction"  data-url="{!! route('m.contents.reply.reduction', ['id' => $item->id]) !!}" >
                                        还原
                                    </button>
                                @else
                                    <button class="btn btn-warning item-delete"  data-url="{!! route('m.contents.reply.destroy', ['id' => $item->id]) !!}" >
                                        删除
                                    </button>

                                @endif

                            </div>

                        </td>
                    </tr>
                    <tr class="collapse trace-{{$item->id}}">
                        <td colspan="7">
                            <table class="table ">
                                <tr>
                                    <td>赞:{!! count($item->picture) !!}</td>
                                    <td>弱:{!! count($item->thumbs_down) !!}</td>
                                </tr>
                                <tr>
                                    <td  colspan="2">内容详细:</td>
                                </tr>

                                <tr>
                                    <td  colspan="2">{{ $item->contents }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
    </div>




@stop

@section('script')
    <script>
        $(function(){
            var locked = true;
            /**
             *  数据回复
             */
            $('.item-reduction').click(function() {

                var _this = $(this);
                swal({
                            title: "确认还原吗?",
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
                                url: _this.attr('data-url'),
                                type: 'POST',
                                data: {
                                    "_method":"PUT",
                                    "_token":$('meta[name="csrf-token"]').attr('content')
                                },
                                cache: false,
                                dataType: 'json',
                                success:function(res) {

                                    if(res.code != 0) {
                                        swal(res.data, '', 'error');
                                        locked = true;
                                    } else {
                                        swal(res.data, '', 'success');
                                        window.location.href = document.location;
                                    }
                                },
                                error:function () {
                                    locked = true;
                                }

                            });

                        }
                );
            });
        })
    </script>
@stop