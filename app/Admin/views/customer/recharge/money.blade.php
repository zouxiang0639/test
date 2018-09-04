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

    <input type="hidden" id="division-json" value='{!! $division !!}'>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.customer.recharge.money.post') !!}",
            "backUrl":"{!! route('m.customer.recharge.list') !!}"
        };
        var division = JSON.parse($("#division-json").val());
        $(function() {

            var countMoney = function() {
                var arr = $('[name="division[]"]').val();
                var num = 0;
                var money = rmoney($('input[name=money]').val());

                if(arr) {
                    arr.forEach(function( val ) {
                        if(division[val]) {
                            num += parseInt(division[val]);
                        }
                    });
                }

                $('#count-money .no-margin').text('用户'+ num +' 充值总金额' + fmoney(money * num))
            };

            $('select[name=type]').change(function() {
                var group = '{!! \App\Consts\Admin\Customer\RechargeTypeConst::GROUP !!}';
                var one = '{!! \App\Consts\Admin\Customer\RechargeTypeConst::ONE !!}';
                var type = $(this).val();

                $('#division').hide();
                $('#user').hide();
                $('#count-money').hide();

                if(type == group) {
                    $('#division').show();
                    $('#count-money').show();
                } else if(type == one) {
                    $('#user').show();
                }
            }).trigger("change");

            $('[name="division[]"]').change(function() {
                countMoney()
            });

            $('input[name=money]').change(function() {
                countMoney()
            }).trigger("change");
        });

        //格式化金额千分位
        function fmoney(s, n) {
            n = n > 0 && n <= 20 ? n : 2;
            s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
            var l = s.split(".")[0].split("").reverse(),
                    r = s.split(".")[1];
            t = "";
            for(i = 0; i < l.length; i ++ )
            {
                t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
            }
            return t.split("").reverse().join("") + "." + r;
        }

        //还原千分位
        function rmoney(s) {
            return parseFloat(s.replace(/[^\d\.-]/g, ""));
        }
    </script>
@stop