@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">{!! $info['title'] !!}</div>
                <form class="article-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="type" value="{!! $info['type'] !!}">
                    <div class="post-txt">

                        <div class="tep2">
                            <input name="title" type="text" placeholder="请填写标题" />
                        </div>
                        <div class="tep3">

                            <p class="area">
                                <textarea style="border: 0px solid #1a3148; width: 787px;" name="contents" ></textarea>
                            </p>
                        </div>
                        <div class="tep4">
                            <a class="post-btn" id="feedback-submit" href="javascript:void(0)">发表</a>
                            <a class="cancel-btn" href="JavaScript:history.go(-1)">返回</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')

    <script src="{{ assets_path("/lib/ckeditor/ckeditor.js") }}"></script>
<script>


    $(function(){

    var locked = true;

    //注册
    $('#feedback-submit').click(function() {
        if (! locked) {
            return false;
        }

        locked = false;
        var _this = $(this);
        var data  = $(".article-form").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: '{!! route('f.feedback.store') !!}',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code == 1020001){
                    swal({
                        title: "",
                        text: "<p class='text-danger'>" + res.msg + "</p>",
                        html: true
                    });
                    locked = true;
                }else if(res.code != 0){
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
                    window.location.href = window.location.href;
                }
            },
            error:function () {
                locked = true;
                _this.attr('disabled',false);
            }

        });
        return false;
    });

    });
</script>
@stop