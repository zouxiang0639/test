$(function () {'use strict';
    $('input[name="price"]').eq(0).click();

    var locked = true;

    $(document).on("click", ".refund", function(e) {
        if (! locked) {
            return false;
        }

        locked = false;

        $.ajax({
            url: $(this).attr('data-url'),
            type: 'POST',
            data:{
            "_method":"PUT",
                "_token":$('meta[name="csrf-token"]').attr('content'),
                "id":$(this).attr('data-id')
             },
            cache: false,
            dataType: 'json',
            success:function(res) {

            if(res.code != 0) {
                $.alert(res.data);
                locked = true;
            } else {
                $.alert(res.data);
                window.location.href =  window.location.href;
            }
            },
            error:function () {
                locked = true;
            }

        });
    });

    $.init();
});



