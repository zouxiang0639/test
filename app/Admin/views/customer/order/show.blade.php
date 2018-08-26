@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        订单<small>详情</small>
    </h1>
@stop
@section('content')

    <div class="row"><div class="col-md-12"><div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{!! route('m.customer.order.list') !!}" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>

                <div class="form-horizontal box-body fields-group">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            用户姓名:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->userName !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            订单类型:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->typeName !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            订单状态:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->statusName !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            定金:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->depositFormat !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            总金额:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->amountFormat !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($info->diifPrice > 0)
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">
                                差价:
                            </label>
                            <div class="col-sm-7 ">
                                <div class="input-group" style="width:100%">
                                    <div class="box box-body  box-solid box-default">
                                        {!! \App\Library\Format\FormatMoney::fen2yuan($info->diifPrice) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            已支付金额:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->paymentFormat !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            下单时间:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->created_at !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!is_null($info->payment_at))
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            支付时间:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    {!! $info->payment_at !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                        <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">
                            订单明细:
                        </label>
                        <div class="col-sm-7 ">
                            <div class="input-group" style="width:100%">
                                <div class="box box-body  box-solid box-default">
                                    @if($info->type == \App\Consts\Order\OrderTypeConst::TAKEOUT)
                                        <table class="table table-hover">
                                        <tr>
                                            <th>名称</th>
                                            <th>数量</th>
                                            <th>定金</th>
                                            <th>价格</th>

                                        </tr>
                                        @foreach($info->child as $item)
                                            <tr>
                                                <td>{!! $item->name !!}</td>
                                                <td>{!! $item->num !!}</td>
                                                <td>{!! $item->deposit !!}</td>
                                                <td>{!! $item->price !!}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    @else
                                        <table class="table table-hover" >
                                            <tr>
                                                <th>名称</th>
                                                <th>数量</th>
                                                <th>折扣</th>
                                                <th>价格</th>

                                            </tr>
                                            @foreach($info->child as $item)
                                                <tr>
                                                    <td>{!! $item->name !!}</td>
                                                    <td>{!! $item->num !!}</td>
                                                    <td>{!! $item->discount !!}</td>
                                                    <td>{!! $item->price !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-header -->
                <!-- form start -->
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.customer.users.update', ['id' => $info->id]) !!}",
            "backUrl":"{!! route('m.customer.users.list') !!}"
        }
    </script>
@stop