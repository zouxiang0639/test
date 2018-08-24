@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">发表新帖</div>
                <form class="article-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="post-txt">
                        <div class="tep1 clearfix">
                            <p class="sel">
                                <label>选择板块:</label>
                                {!! Form::select('tags', Forum::Tags()->getTagsOption(), '', ['placeholder'=>'请选择']) !!}
                            </p>
                            <p class="ck" style="display: none">
                                <input type="checkbox" id="check1" value="123" name="is_hide" class="check">
                                <label for="check1">匿名</label>
                            </p>
                        </div>

                        <div class="tep2">
                            <input name="title" type="text" placeholder="请填写标题" />
                        </div>
                        <div class="tep3">

                            <p class="area">
                                <textarea name="contents" ></textarea>
                            </p>
                            <p class="text">
                                <input name="source" value="" type="text" placeholder="转载内容请填写原作者与来源，原创内容无需填写" />
                            </p>
                        </div>
                        <div class="tep4">
                            <a class="post-btn" id="article-submit" data-action="{!! route('f.article.create.put') !!}" href="javascript:void(0)">发表</a>
                            <a class="cancel-btn" href="javascript:void(0)">取消</a>
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
            $('select[name=tags]').change(function() {
                var tags = $(this).val();
                if(tags == 4) {
                    $('.ck').show();
                } else {
                    $('.ck').hide();
                }
            });

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
                        ['Image','Html5video','Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
                        //样式       格式      字体    字体大小
                        ['Styles','Format','Font','FontSize'],
                    ]
                }
            );
        });

        var locked = true;

        //注册
        $('#article-submit').click(function() {

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
                url: _this.attr('data-action'),
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
                        swal('发布成功', '', 'success');
                        window.location.href = res.data;
                    }
                },
                error:function () {
                    locked = true;
                    _this.attr('disabled',false);
                }

            });
            return false;
        });
    </script>
    @stop