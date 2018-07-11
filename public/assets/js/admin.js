$(function(){
    var locked = true;
    $('#form-submit').click(function(){
        var config = initialAjAx;
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
        var data  = $(".form-horizontal").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: config.url,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code != 0) {
                    var error = res.data;
                    console.log(error);
                    for ( var i in error ) {
                        $('.'+i).after("<div class='text-danger'>" + error[i][0] + "</div>");
                    }
                    _this.attr('disabled',false);
                    locked = true;
                } else {
                    alert(res.data.msg);
                    window.location.href = '';
                }
            },
            error:function () {
                _this.attr('disabled',false);
                locked = true;
            }

        });
        return false;
    });
});