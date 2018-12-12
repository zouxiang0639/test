@extends('h5::layouts.master')

@section('style')
    <style>
        .reply-show img{
            max-width: 100%;
            padding: 10px 0;
        }
    </style>
@stop

@section('title')
    -{!! $info->title !!}
@stop

@section('content')
    <div class="des-info">
        <div class="article">
            <div class="title"><h1>{{ $info->title  }}</h1></div>
            <div class="con">
                <p>
                    <span>帖子ID : {!! $info->id !!}</span>
                    <span>发帖人 :
                        @if($info->tags == 4 && $info->is_hide == \App\Consts\Common\WhetherConst::YES)
                            匿名
                        @else
                            <a href="{!! route('h.space.index', ['user_id' => $info->issuer]) !!}"><i>{{ $info->issuers->name  }}</i></a>
                        @endif


                        (注册时间:{{ mb_substr($info->issuers->created_at, 0, 10) }} 登陆次数:{{ $info->issuers->login_num }})</span>
                </p>
                <p>
                    <span>推荐 : {{ $info->recommend_count }}</span>
                    <span>浏览 : {{ $info->browse }}</span>
                    <span>回复: {{ $replyCount }}</span>
                    <span>发帖时间 : {{ $info->created_at }}</span>
                </p>
            </div>
        </div>
        <div class="article-show">
            <div class="content">
                @if(is_null($info->deleted_at))
                    {!! $info->contents !!}
                @else
                    文章已被删除
                @endif
            </div>

            <div class="show-op clearfix" style="padding-top: 0.2rem">

                <div style=" float: left" class="copyVideo reprint" >
                    @if($info->source)
                        来源:{!! $info->source !!}
                    @endif
                </div>


                <div style="float: right;padding-top: 0.1rem;">
                    <a class="check-auth" href="{!! route('h.feedback.report', ['article_id' => $info->id]) !!}">举报！</a>
                    <a class="col article-star" style="padding-right: 15px;" href="javascript:void(0)">
                        <i class="coll-ico fa fa-heart {!! in_array($userId, $info->star) ? "default" : "" !!}"></i>收藏
                    </a>
                </div>


            </div>
        </div>
        <div class="zan-show" >
            <div class="con">
                <a class="thumbs-up thumbs gd" data-href="{!! route('f.article.thumbsUp',['id' => $info->id]) !!}">
                    <i class="fa fa-thumbs-o-up {!! in_array($userId, $info->thumbs_up) ? "default" : "" !!}"></i>
                    <span class="num">{!! $info->recommend_count !!}</span>
                </a>

                <a class=" thumbs-down thumbs bad" data-href="{!! route('f.article.thumbsDown',['id' => $info->id]) !!}" >
                    <i class="fa fa-thumbs-o-down {!! in_array($userId, $info->thumbs_down) ? "default" : "" !!}"></i>
                    <span class="num">{!! count($info->thumbs_down) !!}</span>
                </a>
            </div>
            <div class="zan-show-title">*{!! config('config.reply_light_green') !!}赞以上变浅绿色，{!! config('config.reply_green') !!}赞以上变绿色，弱数超过赞数{!! config('config.reply_light_red') !!}个变浅红色，楼主回复为蓝色</div>
        </div>
        @include('h5::article.reply_ajax')

        <div class="reply-push" style="clear: both;">
            <div class="img" >
            </div>
            <form class="reply-form">
                <input type="hidden" name="article_id" value="{!! $info->id !!}">
                <input type="hidden" name="at" value="0">
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" class="picture" name="picture" value="">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <textarea name="contents"  class="check-auth"></textarea>

                <div class="btn clearfix" style="display: block;border: 0px solid transparent;padding: 0px;">
                    <a class="txt reply—submit" data-href="{!! route('h.reply.store') !!}">回复发表</a>
                    <input style="display: none" class="layui-upload-file" accept="undefined" name="file" type="file">
                    <a   class="xinfo img img—submit" data-href="{!! route('f.reply.store') !!}"><i class="fa fa-image"></i></a>
                </div>
            </form>
        </div>

    </div>
@stop


@section('script')
    @parent
    <script>
        $(function(){
            var locked = true;
            var data = {
                'ext': ['jpg', 'png', 'gif', 'jpeg'],
                'size': 1,
                'limit': 4
            };

            $('.content img').removeAttr("height").removeAttr("style").removeAttr('width');

            //上传文件
            $("body").on('click', '.abc', function(){
                $('.reply-form .img').click(function(){
                    $(this).siblings('.layui-upload-file').click();
                }).siblings('.layui-upload-file').change(function(){

                    if($(this).val()) {

                        var _this = $(this);
                        var file =  this.files[0];
                        var imgPath = $(this).parents('.clearfix').siblings('.picture').val();

                        if(imgPath == '') {

                            imgPath = new Array();
                        } else {
                            imgPath = imgPath.split(",");
                        }

                        if(imgPath.length >= data.limit) {
                            swal("图片只能上传" + data.limit +'张', '', 'error');
                            return false;
                        }

                        var type = file.name.match(/^(.*)(\.)(.{1,8})$/)[3];
                        if (data.ext.indexOf(type) < 0) {
                            swal("请上传图片", '', 'error');
                            return false;
                        }

                        if(file.size > data.size * 1024 * 1024)
                        {
                            swal("上传的图片大小不能超过"+data.size+"M！", '', 'error');
                            return false;
                        }

                        var formData = new FormData();
                        formData.append('file', file);
                        formData.append('_method', 'PUT');
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        $.ajax({
                            url: '{!! route('f.upload.img') !!}',
                            type: 'POST',
                            cache: false, //上传文件不需要缓存
                            data: formData,
                            processData: false, // 告诉jQuery不要去处理发送的数据
                            contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                            dataType: 'json',
                            success: function (res) {

                                if(res.code == 1020001){
                                    swal({
                                        title: "",
                                        text: "<p class='text-danger'>" + res.msg + "</p>",
                                        html: true
                                    });
                                }else if(res.code != 0) {

                                } else {
                                    _this.parents('.reply-form').siblings('.img').append('<img src="'+res.data.url+'">');
                                    imgPath.push(res.data.filePath);
                                    _this.parents('.clearfix').siblings('.picture').val(imgPath.join());
                                }
                            },
                            error: function (data) {

                            }
                        });
                        $(this).val('');
                    }
                });
            });
            $('.abc').click();

            $('.article—delete').click(function() {
                var _this = $(this);
                swal({
                            title: "确认删除?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "确定",
                            closeOnConfirm: false,
                            cancelButtonText: "取消"
                        },
                        function(){

                            if (! locked) {
                                return false;
                            }

                            locked = false;
                            $.ajax({
                                url: _this.attr('data-url'),
                                type: 'POST',
                                data: {
                                    "_method":"DELETE",
                                    "_token":$('meta[name="csrf-token"]').attr('content')
                                },
                                cache: false,
                                dataType: 'json',
                                success:function(res) {
                                    if(res.code != 0) {
                                        swal(res.data, '', 'error');

                                    } else {
                                        swal(res.data, '', 'success');
                                        setTimeout(" window.history.go(-1); ",2000);
                                    }
                                    locked = true;
                                },
                                error:function () {
                                    locked = true;
                                }

                            });

                        }
                );
            });

            //收藏
            $('.article-star').click(function() {
                var _this = $(this);
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('f.article.star', ['id' => $info->id]) !!}',
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
                            swal({
                                title: "",
                                text: "<p class='text-danger'>" + res.data + "</p>",
                                html: true
                            });

                        } else {
                            if(res.data == true) {
                                _this.children("i").addClass('default');
                            } else {
                                _this.children("i").removeClass('default');
                            }
                        }

                        locked = true;
                    },
                    error:function () {
                        locked = true;
                    }

                });
            });

            //推荐
            $('.article-recommend').click(function() {
                var numClass = $(this).children(".num");
                var num = parseInt(numClass.text());
                var _this = $(this);

                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('f.article.recommend', ['id' => $info->id]) !!}',
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
                            swal({
                                title: "",
                                text: "<p class='text-danger'>" + res.data + "</p>",
                                html: true
                            });

                        } else {
                            if(res.data == true) {
                                _this.addClass('default');
                                numClass.text(num + 1);
                            } else {
                                _this.removeClass('default');
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

            /**
             *  回复
             */
            $("body").on('click', '.reply—submit', function(){

                if (! locked) {
                    return false;
                }
                console.log($(this).parents('.reply-form').serialize());
                locked = false;

                $.ajax({
                    url: $(this).attr('data-href'),
                    type: 'POST',
                    data: $(this).parents('.reply-form').serialize(),
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

                        } else {
                            swal(res.data, '', 'success');
                            window.location.href =  window.location.href;
                        }
                        locked = true;
                    },
                    error:function () {
                        locked = true;
                    }

                });

                return false;

            });

            //异步加载数据
            var  lockedPage = true;
            var page = 0;
            $('#reply-page').click(function() {
                if (! lockedPage) {
                    return false;
                }

                lockedPage = false;

                $.ajax({
                    url: '{!! route('f.reply.show', ['article_id' => $info->id]) !!}',
                    type: 'POST',
                    data: {
                        'page' : page,
                        "_method": "PUT",
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            $('.page-reply').html(res.data);
                        } else {
                            $('#reply-content').append(res.data);
                            page ++;
                            lockedPage = true;
                        }
                    },
                    error:function () {
                        lockedPage = true;
                    }

                });

            }).trigger("click");

        });


        function copyVideoUrl(event){

            var value = $(event.target).closest("span").attr('value');
            var success;
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            try{
                success = document.execCommand("copy");
            }catch (e){
                succeed = false;
            }

            if(success){
                swal('拷贝成功', '', 'success');
            }

            $temp.remove();
        }
    </script>
@stop