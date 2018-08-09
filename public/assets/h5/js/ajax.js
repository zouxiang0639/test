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



