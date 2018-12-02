@extends('h5::layouts.master')

@section('content')
    <div class="post-tit">发表新帖</div>
    <div class="article-create">

        <div class="post-con">

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
            <span class="help-block">
                <i class="fa fa-info-circle"></i>&nbsp;（每天发表文章章超出{!! config('config.day_article') !!}后,每发表一篇文章将减10个积分）
            </span>
                    <div class="tep4">
                        <a class="post-btn" id="article-submit" data-action="{!! route('h.article.create.put') !!}" href="javascript:void(0)">发表</a>
                        <a class="cancel-btn" href="JavaScript:history.go(-1)">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @parent
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

                            //图片     表格       水平线            表情       特殊字符        分页符
                            ['Image',/*'Html5video',*/'Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],

                        ]
                    }
            );
        });

        var locked = true;

        //提交
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