@extends('admin::layouts.master')

@section('content-header')
    <h1>
        数据备份<small>备份文件</small>
    </h1>
@stop
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left btn-group">
                <div class="btn-group" style="margin-right: 10px">
                    <a href="{!! route('m.system.backup.list') !!}" class="btn btn-sm btn-success">
                        <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;返回
                    </a>

                </div>
            </div>
            <div class="pull-right">

            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>备份名称</th>
                    <th>卷数</th>
                    <th>压缩</th>
                    <th>数据大小</th>
                    <th>备份时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! date('Ymd-His', $item['time']) !!}</td>
                        <td>{!! $item['part'] !!}</td>
                        <td>{!! $item['compress'] !!}</td>
                        <td>{!! $item['size'] !!}</td>
                        <td>{!! date('Y-m-d H:i:s', $item['time']) !!}</td>
                        <td>-</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-default item-delete" data-url="{!! route('m.system.backup.destroy',['file' => $item['name']]) !!}">删除</button>
                                <a class="btn btn-default item-put" href="{!! route('m.system.backup.download',['file' => $item['name']]) !!}">下载</a>
                                @if(config('admin.data_backup_import'))
                                <button class="btn btn-default import" data-href="{!! route('m.system.backup.import',['time' => $item['time']]) !!}">还原</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="box-footer clearfix">

        </div>
        <!-- /.box-body -->
    </div>
@stop
@section('script')
    @if(config('admin.data_backup_import'))
    <script>
        $(function() {
            $(".import").click(function(){
                var self = this, code = ".";
                swal({
                    title: "确认删除?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    closeOnConfirm: false,
                    cancelButtonText: "取消"
                },function(){

                    $.post($(self).attr('data-href'),{
                        "_token":$('meta[name="csrf-token"]').attr('content')
                    }, success, "json");
                    window.onbeforeunload = function(){ return "正在还原数据库，请不要关闭！" };
                    return false;

                    function success(data){
                        if(data.code == 0){
                            if(data.data.gz){
                                data.msg += code;
                                if(code.length === 5){
                                    code = ".";
                                } else {
                                    code += ".";
                                }
                            }
                            $(self).parents('td').prev().text(data.data.msg);
                            swal(data.data.msg, '', 'success');
                            if(data.data.part){
                                $.post(
                                    '{!! route('m.system.backup.import.put') !!}',
                                    {
                                        "_method":"PUT",
                                        "_token":$('meta[name="csrf-token"]').attr('content'),
                                        "part" : data.data.part,
                                        "start" : data.data.start
                                    },
                                    success,
                                    "json"
                                );
                            }  else {
                                window.onbeforeunload = function(){ return null; }
                            }
                        } else {
                            swal(data.data, '', 'error');
                        }
                    }
                });


            })
        })
    </script>
    @endif
@stop