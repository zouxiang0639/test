@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        外卖<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <button type="button" class="btn {!! $takeoutDeadlineCheck ? 'btn-warning': 'btn-primary' !!}" data-toggle="modal" data-target="#takeout_deadline">
                    {!! $takeoutDeadlineCheck ? '已开启外卖' : '设置开启外卖' !!}

                </button>
            </div>

            <div class="pull-right">
                <a href="{!! route('m.canteen.takeout.create') !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>名称</th>
                    <th>库存</th>
                    <th>价格</th>
                    <th>定金</th>
                    <th>限购</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->deposit }}</td>
                        <td>{{ $item->limit }}</td>
                        <td class="switch_submit" data-href="{!! route('m.canteen.takeout.status', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->status) !!}
                        </td>
                        <td>
                            <a href="{!! route('m.canteen.takeout.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.canteen.takeout.destroy', ['id' => $item->id]) !!}" class="item-delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->

        <div class="modal fade" id="takeout_deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">设置开启外卖</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">

                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group" style="margin: 0px 8px;">
                                <label for="recipient-name" class="control-label">外卖截止时间:</label>
                                {!! Form::datetime('takeout_deadline', config('config.takeout_deadline'), ['class' => 'form-control '], 'YYYY-MM-DD') !!}
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary form-submit">提交</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.system.config.set.post') !!}",
            "backUrl":"{!! route('m.canteen.takeout.list') !!}"
        }
    </script>
@stop