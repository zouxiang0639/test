@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        食谱<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#takeout_deadline">--}}
                    {{--餐费设置--}}
                {{--</button>--}}
            </div>

            <div class="pull-right">
                <a href="{!! route('m.canteen.recipes.create') !!}" class="btn btn-sm btn-success">
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
                    <th>就餐日期</th>
                    <th>早餐</th>
                    <th>午餐</th>
                    <th>晚餐</th>

                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->morning }}</td>
                        <td>{{ $item->lunch }}</td>
                        <td>{{ $item->dinner }}</td>
                        <td>
                            <a href="{!! route('m.canteen.recipes.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.canteen.recipes.destroy', ['id' => $item->id]) !!}" class="item-delete">
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
                    <form class="form-horizontal box-body fields-group">
                    <div class="modal-body">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                早餐费:
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    {!! Form::currency('morning_price', config('config.morning_price'), ['class' => 'form-control']) !!}
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                午餐费:
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    {!! Form::currency('lunch_price', config('config.lunch_price'), ['class' => 'form-control']) !!}
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                晚餐费:
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    {!! Form::currency('dinner_price', config('config.dinner_price'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
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
            "backUrl":"{!! route('m.canteen.recipes.list') !!}"
        }
    </script>
@stop