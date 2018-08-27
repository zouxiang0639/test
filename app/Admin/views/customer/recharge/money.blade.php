@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        充值<small>余额</small>
    </h1>
@stop
@section('content')

    <div class="row"><div class="col-md-12"><div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">充值</h3>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{!! route('m.customer.recharge.list') !!}" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>

                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              {!! $form !!}
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.customer.recharge.money.post') !!}",
            "backUrl":"{!! route('m.customer.recharge.list') !!}"
        };

        $(function() {
            $('select[name=type]').change(function() {

                var group = '{!! \App\Consts\Admin\Customer\RechargeTypeConst::GROUP !!}';
                var one = '{!! \App\Consts\Admin\Customer\RechargeTypeConst::ONE !!}';
                var type = $(this).val();

                $('#division').hide();
                $('#user').hide();

                if(type == group) {
                    $('#division').show();
                } else if(type == one) {
                    $('#user').show();
                }
            }).trigger("change");
        })
    </script>
@stop