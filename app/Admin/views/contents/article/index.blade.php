@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
@stop

@section('content-header')
    <h1>
         文章<small>列表</small>
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
                    <div class="input-group input-group-sm">
                        {!! Form::select('tag', $tags, Input::get('tag'), ['class'=>'form-control','placeholder'=>'全部']) !!}
                    </div>
                    <div class="input-group input-group-sm ">
                        {!! Form::text('id', Input::get('id'), ['class'=>'form-control','placeholder'=>'文章ID']) !!}
                    </div>
                    <div class="input-group input-group-sm" >
                        {!! Form::text('title', Input::get('title'), ['class'=>'form-control','placeholder'=>'标题']) !!}
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
                    <th>编号</th>
                    <th>标题</th>
                    <th>标签</th>
                    <th>发表人</th>
                    <th>浏览量</th>
                    <th>推荐量</th>
                    <th>发表时间</th>
                    <th width="200">操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>

                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->tagsName }}</td>
                        <td>{{ $item->issuerName }}</td>
                        <td>{{ $item->browse }}</td>
                        <td>{!! $item->recommend_count !!}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-default" href="{!! route('m.contents.article.edit', ['id' => $item->id]) !!}">
                                    详细
                                </a>
                                @if($item->is_hot == \App\Consts\Common\WhetherConst::NO && !Input::get('recycle'))
                                    <button class="btn btn-default item-hot-search" data-url="{!! route('m.contents.article.hot.search', ['id' => $item->id]) !!}">
                                        推热搜
                                    </button>
                                @endif

                                @if(Input::get('recycle'))
                                    <button class="btn  btn-warning item-reduction"  data-url="{!! route('m.contents.article.reduction', ['id' => $item->id]) !!}" >
                                        还原
                                    </button>
                                @else
                                    <button class="btn btn-default item-delete"  data-url="{!! route('m.contents.article.destroy', ['id' => $item->id]) !!}" >
                                        删除
                                    </button>
                                @endif

                            </div>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->
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

            /**
             *  数据回复
             */
            $('.item-hot-search').click(function() {

                var _this = $(this);
                swal({
                            title: "确认要推送到热搜吗?",
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