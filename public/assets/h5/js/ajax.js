$(function () {'use strict';
    $('input[name="price"]').eq(0).click();

    //post 请求
    $(document).on("click", ".ajax-post", function(e) {
        var url, d,data;
        d    = $(this).parents('.form-horizontal');
        url  = d.attr('action');
        data = d.serialize();
        $.ajax({
            type:'post',
            url:url,
            data :data ,
            dataType:  'json',
            success: function(json) {
                $.hideIndicator(); //取消 迷你指示器
                if(json.code == 1){
                   if(json.url){
                       $.toast(json.msg+'，正在跳转...', 1000);
                        setTimeout(function() {
                            window.location.href=json.url;
                        },1000);
                   }else{
                       $.alert(json.msg);
                   }

                }else if(json.code == 0){       
                    $.alert(json.msg);
                }
            },
            error:function(xhr){          //上传失败                     
                $.alert(xhr.responseText);
            },
            beforeSend:function(){
                $.showIndicator(); //迷你指示器
            }

        });
    });

    //表单提交
    $(document).on("click", ".submit-post", function(e) {

        var url, d,data,check;
        d    = $(this).parents('.form-horizontal');
        url  = d.attr('action');
        data = d.serialize();
        $.ajax({
            type:'post',
            url:url,
            data :data ,
            dataType:  'json',
            success: function(json) {
                if(json.code == 1){
                    d.submit();
                }else if(json.code == 0){
                    $.alert(json.msg);
                }
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
            }
        });
    });

    //获取产品分期列表
    $(document).on("click", "#filling-gutter", function(e) {

        var url,price,months;
        price   = parseInt($('input[name="price"]:checked').attr('price'));

        if(isNaN(price)){
            price   = parseInt($('input[name="price"]').val());

        }

        months   = parseInt($('input[name="goods"]:checked').attr('months'));
        if(isNaN(months)){
            months   = parseInt($('input[name="goods"]').attr('months'));
        }

        url     = $(this).attr('post-url');

        $.ajax({
            type:'post',
            url:url,
            data :'price='+price+'&months='+months ,
            dataType:  'json',
            success: function(json) {
                $('#filling-popup-html').html(json.data);
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
            }
        });
    });

    //a 标签 ajax
    $(document).on("click", ".post-a", function(e) {
        var url,data,btn;
        btn     = $(this);
        url     = btn.attr('post-url');
        $.ajax({
            type:'post',
            url:url,
            dataType:  'json',
            success: function(json) {
                if(json.code == 1){
                    $.alert(json.msg);
                    if(json.url){
                        setTimeout(function() {
                            window.location.href=json.url;
                        },3e3);
                    }
                }else if(json.code == 0){
                    $.alert(json.msg);
                }
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
                btn.removeAttr("style");
            },
            beforeSend:function(){
                btn.css({'pointer-events': 'none','background-color':'#b4b1ae'});
            }
        });
    });


    //获取html页面
    $(document).on("click", ".get-html", function(e) {
        var url,data,btn,title;
        btn     = $(this);
        url     = btn.attr('get-url');
        title   = btn.attr('get-title');
        $(".title").html(title);
        $.ajax({
            type:'get',
            url:url,
            dataType:  'json',
            success: function(json) {
                var html = $(json).find("#ajaxContent").html();
                $("#get-html").html(html);
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
                btn.removeAttr("style");
            }
        });
    });

    //短信验证
    $(document).on("click", ".post-verify", function(e) {
        var url,data,btn;
        btn     = $(this);
        data    = $('.form-horizontal').serialize();
        url     = btn.attr('post-url');
        $.ajax({
            type:'post',
            url:url,
            data :data ,
            dataType:  'json',
            success: function(json) {
                if(json.code == 1){
                    var  b = 60;
                    var	a = setInterval(function() {
                        if( 0 <= b){
                            btn.html(b + "秒后重发");
                        }else{
                            btn.html("获取验证码");
                            btn.removeAttr("style");
                            clearInterval(a);
                        }
                        return b--;
                    },1e3);
                    $.alert(json.msg);
                }else if(json.code == 0){
                    $.alert(json.msg);
                    btn.removeAttr("style");
                }
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
                btn.removeAttr("style");
            },
            beforeSend:function(){
                btn.css({'pointer-events': 'none','background-color':'#b4b1ae'});
            }
        });
    });

    //邮箱验证
    $(document).on("click", ".post-email", function(e) {
        var url,email,btn;
        btn    = $(this);
        email = $('input[name="email"]').val();
        url    = btn.attr('post-url');
        $.ajax({
            type:'post',
            url:url,
            data :'email='+email ,
            dataType:  'json',
            success: function(json) {
                if(json.code == 1){
                    var  b = 30;
                    var a = setInterval(function() {
                        if( 0 <= b){
                            btn.html(b + "秒后重发");
                        }else{
                            btn.html("获取验证码");
                            btn.removeAttr("style");
                            clearInterval(a);
                        }
                        return b--;
                    },1e3);
                    $.alert(json.msg);
                }else if(json.code == 0){
                    $.alert(json.msg);
                    btn.removeAttr("style");
                }
            },
            error:function(xhr){          //上传失败
                $.alert(xhr.responseText);
                btn.removeAttr("style");
            },
            beforeSend:function(){
                btn.css({'pointer-events': 'none','background-color':'#b4b1ae'});
            }
        });
    });

    //卡号 4位一个空格
    $(document).on("keyup", ".box", function(e) {
        var value=$(this).val().replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");
        $(this).val(value)
    });


    //数据删除
    $(document).on('click','.post-delete', function () {
        var url,data,btn;
        btn     = $(this);
        url     = btn.attr('post-url');

        var buttons1 = [
            {
                text:  $('#post_delete_title').val(),
                label: true
            },
            {
                text: '确定',
                bold: true,
                color: 'danger',
                onClick: function() {
                    $.ajax({
                        type:'post',
                        url:url,
                        dataType:  'json',
                        success: function(json) {
                            $.hideIndicator(); //取消 迷你指示器
                            if(json.code == 1){
                                if(json.type == 1){
                                    btn.parent().parent().remove();
                                    return false
                                }
                                $.toast('操作成功，正在跳转...', 1000);
                                setTimeout(function() {
                                    window.location.href=json.url;
                                },1000);

                            }else if(json.code == 0){
                                $.alert(json.msg);
                            }
                        },
                        error:function(xhr){  //失败
                            $.alert(xhr.responseText);
                            btn.removeAttr("style");
                        },
                        beforeSend:function(){
                            $.showIndicator(); //迷你指示器
                        }
                    });
                }
            }
        ];
        var buttons2 = [
            {
                text: '取消',
                bg: 'white'
            }
        ];
        var groups = [buttons1, buttons2];
        $.actions(groups);
    });


    $.init();
});



