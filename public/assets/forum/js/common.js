$(function(){
    var locked = true;

    //注册
    $('#register-submit').click(function() {
        if (! locked) {
            return false;
        }

        locked = false;
        var _this = $(this);
        var data  = $(".register-form").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: _this.attr('data-action'),
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code != 0){
                    var errorHtml = '';
                    var error = res.data;
                    for ( var i in error ) {
                        errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                    }
                    swal({
                        title: "",
                        text: errorHtml,
                        html: true
                    });
                    _this.attr('disabled',false);
                    locked = true;
                } else {
                    swal(res.data, '', 'success');
                    setTimeout("window.location.href =  window.location.href; ",2000);
                }
            },
            error:function () {
                locked = true;
                _this.attr('disabled',false);
            }

        });
        return false;
    });

    //登录
    $('#login-submit').click(function() {
        if (! locked) {
            return false;
        }

        locked = false;
        var _this = $(this);
        var data  = $(".login-form").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: _this.attr('data-action'),
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code == 1020002) {
                    $('.login-captcha').show();
                    swal({
                        title: "",
                        text: "<p class='text-danger'>" + res.data + "</p>",
                        html: true
                    });
                } else if(res.code != 0){
                    var errorHtml = '';
                    var error = res.data;
                    for ( var i in error ) {
                        errorHtml += "<p class='text-danger'>" + error[i][0] + "</p>"
                    }
                    swal({
                        title: "",
                        text: errorHtml,
                        html: true
                    });
                    _this.attr('disabled',false);
                    locked = true;
                } else {

                    swal(res.data, '', 'success');
                    setTimeout("window.location.href =  window.location.href; ",2000);
                }
            },
            error:function () {
                locked = true;
            }

        });
        return false;
    });

    /**
     *  点赞
     */
    $(".thumbs").click(function(){

        var numClass = $(this).children(".num");
        var num = parseInt(numClass.text());
        var _this = $(this);

        if (! locked) {
            return false;
        }

        locked = false;

        $.ajax({
            url: $(this).attr('data-href'),
            type: 'POST',
            data: {
                "_method": "PUT",
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code == 1020001){
                    swal({
                        title: "",
                        text: "<p class='text-danger'>" + res.msg + "</p>",
                        html: true
                    });

                }else if(res.code != 0) {
                    swal(res.data, '', 'error');

                } else {

                    if(res.data == true) {
                        _this.children("i").addClass('default');
                        numClass.text(num + 1);
                    } else {
                        _this.children("i").removeClass('default');
                        numClass.text(num - 1);
                    }
                }
                locked = true;
            },
            error:function () {
                locked = true;
            }

        });
    });

    $('.clearfix .post').click(function() {
        if($('meta[name="auth—num"]').attr('content')) {
            return true;
        }
        swal('请登录会员', '', 'error');
        return false;
    });

    $(".new-inner").on('click', '.fa-comment-o', function(){
        if($('meta[name="auth—num"]').attr('content')) {
            return true;
        }
        swal('请登录会员', '', 'error');
        return false;
    });

    $('.feedback-create a').on('click', function(){
        if($('meta[name="auth—num"]').attr('content')) {
            return true;
        }
        swal('请登录会员', '', 'error');
        return false;
    });

    $('.article-report').on('click', function(){
        if($('meta[name="auth—num"]').attr('content')) {
            return true;
        }
        swal('请登录会员', '', 'error');
        return false;
    });

});

function deleteAb(obj) {
    $(obj).parents('li').remove();
}