$(function(){
    $("body").on('click', '.check-auth', function(){
        if($('meta[name="auth—num"]').attr('content')) {
            return true;
        }
        swal('请登录会员', '', 'error');
        return false;
    });
});