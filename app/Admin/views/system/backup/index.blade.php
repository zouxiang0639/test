@extends('admin::layouts.master')

@section('content-header')
    <h1>
        数据备份<small>列表</small>
    </h1>
@stop
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left btn-group">
                <button id="export" class="btn btn-primary" autocomplete="off">立即备份</button>
                <button class="btn btn-primary post-submit" data-href="{!! route('m.system.backup.optimize') !!}">优化表</button>
                <button class="btn btn-primary post-submit" data-href="{!! route('m.system.backup.repair') !!}">修复表</button>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! route('m.system.backup.file') !!}">备份文件列表</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <form id="export-form" method="post" action="{!! route('m.system.backup.export') !!}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-hover">
                    <tr>
                        <th><input class="check-all" checked="chedked" type="checkbox" value=""></th>
                        <th>表名</th>
                        <th>描述</th>
                        <th>数据量</th>
                        <th>数据大小</th>
                        <th>创建时间</th>
                        <th>备份状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($list as $item)
                        <tr>
                            <td><input class="ids" checked="chedked" type="checkbox" name="tables[]" value="{!! $item->Name !!}"></td>
                            <td>{!! $item->Name !!}</td>
                            <td>{!! $item->Comment !!}</td>
                            <td>{!! $item->Rows !!}</td>
                            <td>{!! $item->Data_length !!}</td>
                            <td>{!! $item->Create_time !!}</td>
                            <td class="info">未备份</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="JavaScript:;"
                                       data-href="{!! route('m.system.backup.optimize', ['tables'=>$item->Name]) !!}">优化表</a>
                                    <a class="btn btn-default" href="JavaScript:;"
                                       data-href="{!! route('m.system.backup.repair', ['tables'=>$item->Name]) !!}">修复表</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>

        <div class="box-footer clearfix">

        </div>
        <!-- /.box-body -->
    </div>
@stop
@section('script')
<script>
//    $(function() {
//        $('.check-all').on('ifChecked', function(){
//            $('input[name=tables]').iCheck('check');
//        });
//
//        $('.check-all').on('ifUnchecked', function(){
//            $('input[name=tables]').iCheck('uncheck');
//        });
//    })

    (function($){
        var $form = $("#export-form"), $export = $("#export"), tables;
        $optimize = $("#optimize"), $repair = $("#repair");

        $optimize.add($repair).click(function(){
            $.post(this.href, $form.serialize(), function(data){
                if(data.code){
                    alertSuccess(data.msg);
                } else {
                    alertError(data.msg);
                }
                setTimeout(function(){
                    $('#top-alert').find('button').click();
                    $(that).removeClass('disabled').prop('disabled',false);
                },1500);
            }, "json");
            return false;
        });

        $export.click(function(){
            $export.parent().children().addClass("disabled");
            $export.html("正在发送备份请求...");
            $.post(
                    $form.attr("action"),
                    $form.serialize(),
                    function(data){
                        if(data.code == 0){
                            tables = data.data.tables;
                            $export.html(data.data.msg + "开始备份，请不要关闭本页面！");
                            backup(data.data.tab);
                            window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                        } else {
                            alertError(data.msg);
                            $export.parent().children().removeClass("disabled");
                            $export.html("立即备份");
                            setTimeout(function(){
                                $('#top-alert').find('button').click();
                                $(that).removeClass('disabled').prop('disabled',false);
                            },1500);
                        }
                    },
                    "json"
            );
            return false;
        });

        function backup(tab, code){
            tab._method = 'PUT';
            tab._token = $('meta[name="csrf-token"]').attr('content');
            code && showmsg(tab.id, "开始备份...(0%)");
            $.post($form.attr("action"), tab, function(data){
                console.log(data);
                if(data.code == 0){
                    showmsg(tab.id, data.data.msg);

                    if(!$.isPlainObject(data.data.tab)){
                        $export.parent().children().removeClass("disabled");
                        $export.html("备份完成，点击重新备份");
                        window.onbeforeunload = function(){ return null };
                        return;
                    }
                    backup(data.data.tab, tab.id != data.data.tab.id);
                } else {
                    alertError(data.msg);
                    $export.parent().children().removeClass("disabled");
                    $export.html("立即备份");
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }, "json");

        }

        function showmsg(id, msg){
            $form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
        }

        var locked = true;
        $('.btn-group a').click(function(){
            if (! locked) {
                return false;
            }

            locked = false;

            $.ajax({
                url: $(this).attr('data-href'),
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                dataType: 'json',
                success:function(res) {
                    if(res.code != 0) {
                        swal(res.data, '', 'error');
                        locked = true;
                    } else {
                        swal(res.data, '', 'success');
                        locked = true;
                    }
                },
                error:function () {
                    locked = true;
                }

            });
        });

        $('.post-submit').click(function() {
            if (! locked) {
                return false;
            }

            locked = false;

            $.ajax({
                url: $(this).attr('data-href'),
                type: 'POST',
                data: $form.serialize(),
                cache: false,
                dataType: 'json',
                success:function(res) {
                    if(res.code != 0) {
                        swal(res.data, '', 'error');
                        locked = true;
                    } else {
                        swal(res.data, '', 'success');
                        locked = true;
                    }
                },
                error:function () {
                    locked = true;
                }

            });
        })
    })(jQuery);
</script>
@stop