$(function(){
    var locked = true;
    var config = initialAjAx;

    /**
    *  表单ajax提交
    */
    $('.form-submit').click(function() {

        try {
            if (typeof(eval('formValidate')) == "function") {
                error = formValidate();
                if (error != '') {
                    error.forEach(function(e) {
                        $('.'+ e.class).after("<div class='text-danger' style='line-height: 20px;'>" + e.error + "</div>");
                    });
                    return false;
                }
            }
        } catch(e) {}

        if (! locked) {
            return false;
        }

        locked = false;
        var _this = $(this);
        var data  = $(this).parents(".form-horizontal").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: config.url,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code == 1010001) {
                    var error = res.data;
                    for ( var i in error ) {
                        $('.'+i).after("<div class='text-danger'>" + error[i][0] + "</div>");
                    }
                    _this.attr('disabled',false);
                    locked = true;
                } else if(res.code != 0){
                    swal(res.data, '', 'error');
                    _this.attr('disabled',false);
                    locked = true;
                } else {
                    swal(res.data, '', 'success');
                    window.location.href = config.backUrl;
                }
            },
            error:function () {
                _this.attr('disabled',false);
                locked = true;
            }

        });
        return false;
    });

    /**
     *  数据删除
     */
    $('.item-delete').click(function() {

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
                    url: _this.attr('data-url'),
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
     *  开关状态更新
     */
    $("input[name=switch_submit]").change(function(){
        if (! locked) {
            return false;
        }

        locked = false;

        $.ajax({
            url: $(this).parent('.switch_submit').attr('data-href'),
            type: 'POST',
            data: {
                "_method": "PUT",
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "status": $(this).val()
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
    })
});