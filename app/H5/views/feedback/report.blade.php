@extends('h5::layouts.master')

@section('style')
    <style>
        .radio{ margin: 0.1rem 0.1rem 0.8rem 0.1rem;}
        .radio input{margin: 0px}
        .radio .col-md-4{margin: 5px}
    </style>
@stop
@section('content')

    <div class="feedback">
        <div class="post-tit">{!! $info['title'] !!}</div>
        <div class="article-create">

            <div class="post-con">
                <form class="feedback-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="type" value="{!! $info['type'] !!}">
                    <input type="hidden" name="article_id" value="{!! Input::get('article_id') !!}">
                    <div class="post-txt">
                        <div class="radio" style="height: 83px;">
                            <div><p>请选择举报内容类型:</p></div>

                            @foreach($info['report_type'] as $key => $value)
                                <div class="col-md-12">{!! Form::radio('report_type', $key) !!}<span>{!! $value !!}</span></div>
                            @endforeach
                        </div>
                        <div class="tep2" style=" clear:both">
                            <input name="title" type="text" placeholder="请填写标题" />
                        </div>
                        <div class="tep3">

                            <p class="area">
                                <textarea name="contents" ></textarea>
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

                            //图片     表格       水平线            表情       特殊字符        分页符
                            ['Image',/*'Html5video',*/'Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],

                        ]
                    }
            );

            //举报提交
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
                var data  = $(".feedback-form").serialize();

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
                            setTimeout(" window.history.go(-1); ",3000);
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