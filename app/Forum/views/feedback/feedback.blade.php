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
                                <textarea id="contents" style="border: 0px solid #1a3148; width: 787px;" name="contents" ></textarea>
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
    var initial = {
        "CKEditorUploadImage": "{{ route('f.upload.img.ckeditor') }}?_method=PUT&_token=" + $('meta[name="csrf-token"]').attr('content')
    };

    $(function(){
    var locked = true;
    CKEDITOR.replace('contents',
            {
                toolbar : [
                    //加粗     斜体，     下划线      穿过线      下标字        上标字
                    ['Bold','Italic','Underline','Strike','Subscript','Superscript'],
                    //数字列表          实体列表            减小缩进    增大缩进
                    ['NumberedList','BulletedList','-','Outdent','Indent'],
                    //左对齐             居中对齐          右对齐          两端对齐
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                    //超链接 取消超链接 锚点
                    ['Link','Unlink','Anchor'],
                    //文本颜色     背景颜色
                    ['TextColor','BGColor'],
                    //全屏           显示区块
                    ['Maximize', 'ShowBlocks','-'],
                    '/',
                    //图片     表格       水平线            表情       特殊字符        分页符
                    ['Image',/*'Html5video',*/'Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
                    //样式       格式      字体    字体大小
                    ['Styles','Format','Font','FontSize'],
                ]
            }
    );
    //建议提交
    $('#feedback-submit').click(function() {

        //解决ckeditor编辑器 ajax上传问他
        if(typeof CKEDITOR=="object"){
            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].updateElement();
            }
        }

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