@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
    <style>
    .img img{
        max-width: 24%;
        padding: 5px;
    }
    </style>
@stop

@section('content')
    <div class="tie-inner">
        <div class="wm-850">
            <div class="inner-info">
                <p>帖子ID : {!! $info->id !!}</p>
                <p>
                    发帖人 : {{ $info->issuers->name  }}
                    (注册时间:{{ mb_substr($info->issuers->created_at, 0, 10) }} 登陆次数:{{ $info->issuers->login_num }})
                </p>
                <p>
                    <span>
                        <a class="article-recommend {!! in_array($userId, $info->recommend) ? "default" : "" !!}">推荐  : <span class="num">{{ $info->recommend_count }}</span></a>

                    </span>
                    <span>浏览 : {{ $info->browse }}</span>
                    <span>回复: {{ $replyCount }}</span>
                </p>
                <p>
                    <span>发帖时间 : {{ $info->created_at }}</span>
                    <span>IP : {{ $info->ip }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="art-info">
        <div class="wm-850">
            <div class="art-con">
                <p class="tit">{{ $info->title }}</p>
                <div class="con-in">
                   {!! $info->contents !!}

                </div>
                @if($info->source)
                <p class="source">来源：{!! $info->source !!}</p>
                @endif
                <div class="link clearfix">
                    <div class="address fl">复制本帖地址<a href="javascript:void(0)"><i></i> http://kongdi.com/humor_1215</a></div>
                    <div class="share fr">
                        <div style="float: inherit; margin-top: 4px;">
                            <a class="bshareDiv" href="http://www.bshare.cn/share">分享按钮</a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=e2f4016d-a184-49b4-832b-65b5519a06ec&style=2&textcolor=#000000&bgcolor=none&bp=weixin,qzone,sinaminiblog,qqim&text=分享"></script>
                        </div>
                            <a class="col article-star" style="padding-right: 15px;" href="javascript:void(0)">
                                <i class="fa fa-heart {!! in_array($userId, $info->star) ? "default" : "" !!}"></i>收藏
                            </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fabulous">
        <div class="wm-850">
            <div class="fabulous-con">
                <a class="are" href="javascript:void(0)">举报!</a>

                <p class="thumbs-up thumbs" data-href="{!! route('f.article.thumbsUp',['id' => $info->id]) !!}" href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-up {!! in_array($userId, $info->thumbs_up) ? "default" : "" !!}"></i>
                    <span class="num">{!! count($info->thumbs_up) !!}</span>
                </p>

                <p class=" thumbs-down thumbs" data-href="{!! route('f.article.thumbsDown',['id' => $info->id]) !!}" href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-down {!! in_array($userId, $info->thumbs_down) ? "default" : "" !!}"></i>
                    <span class="num">{!! count($info->thumbs_down) !!}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="com-new">
        <div class="wm-850">
            <div class="new-container new-inner">
                <div class="new-inner-tit">*超过10赞底色变为浅绿色，超过100赞底色变为绿色，弱数超过赞数10个底色变为浅红色，楼主回复底色为黄色</div>
                <div class="com-tie">

                    <ul id="reply-content">
                        <p class="abc"></p>
                    </ul>
                </div>

                <div class="page-reply">
                    @if($replyCount)
                    <a id="reply-page">加载更多</a>
                    @endif
                </div>
                <div class="edit-container">
                    <div class="img" >
                    </div>
                    <div class="con" style="margin: 0px 17px;">
                        <form class="reply-form">
                            <input type="hidden" name="article_id" value="{!! $info->id !!}">
                            <input type="hidden" name="at" value="0">
                            <input type="hidden" name="parent_id" value="0">
                            <input type="hidden" class="picture" name="picture" value="">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="tea">
                                <textarea name="contents"></textarea>
                            </div>
                            <div class="opt">
                                <a   class="btn btn-primary img img—submit" data-href="{!! route('f.reply.store') !!}"><i class="fa fa-image"></i></a>
                                <input style="display: none" class="layui-upload-file" accept="undefined" name="file" type="file">
                                <button   class="btn btn-primary txt reply—submit" data-href="{!! route('f.reply.store') !!}">回复</button>
                            </div>
                        </form>
                    <div>
                </div>

                <div style="display: none">

                    <div class="reply">
                        <div class="img" >
                        </div>
                        <div class="con">
                            <form class="reply-form">
                                <input type="hidden" name="article_id" value="{!! $info->id !!}">
                                <input type="hidden" name="at" value="0">
                                <input type="hidden" name="parent_id" value="0">
                                <input type="hidden" class="picture" name="picture" value="">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="tea">
                                    <textarea name="contents"></textarea>
                                </div>
                                <div class="opt">
                                    <a   class="btn btn-primary img img—submit" data-href="{!! route('f.reply.store') !!}"><i class="fa fa-image"></i></a>
                                    <input style="display: none" class="layui-upload-file" accept="undefined" name="file" type="file">
                                    <button   class="btn btn-primary txt reply—submit" data-href="{!! route('f.reply.store') !!}">回复</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="com-new">
        <div class="wm-850">
            <div class="new-container">
                @include('forum::partials.advert')
                <div class="new-tit"><i></i></div>
                @include('forum::partials.all_article')
            </div>
        </div>
    </div>
    @include('forum::partials.ad')
@stop

@section('script')
    @parent
                <script src="{{  assets_path("/lib/layer-v3.1.1/layer.js") }}"></script>
    <script>

        $(function(){
            var locked = true;
            var comTie =  $(".com-tie");
            var data = {
                'ext': ['jpg', 'png', 'gif', 'jpeg'],
                'size': 1,
                'limit': 4
            };

            //上传文件
            comTie.on('click', '.abc', function(){
                $('.opt .img').click(function(){
                    $(this).siblings('.layui-upload-file').click();
                }).siblings('.layui-upload-file').change(function(){
                    if($(this).val()) {

                        var _this = $(this);
                        var file =  this.files[0];
                        var imgPath = $(this).parent('.opt').siblings('.picture').val();

                        if(imgPath == '') {

                            imgPath = new Array();
                        } else {
                            imgPath = imgPath.split(",");
                        }
                        console.log(imgPath);
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
                                    _this.parents('.con').siblings('.img').append('<img src="'+res.data.url+'">');
                                    imgPath.push(res.data.filePath);
                                    _this.parent('.opt').siblings('.picture').val(imgPath.join());
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
            $(".new-container").on('click', '.reply—submit', function(){

                if (! locked) {
                    return false;
                }

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

            //异步加载回复子数据
            comTie.on('click', '.reply-show-child', function(){
                var parentId = $(this).attr('data-id');
                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: '{!! route('f.reply.show.child') !!}',
                    type: 'POST',
                    data: {
                        "_method": "PUT",
                        'parent_id' : parentId,
                        'article_id' : '{!! $info->id !!}',
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            $('.page').html(res.data);
                        } else {
                            $('.child-' + parentId).html(res.data);
                            locked = true;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });

            });

            comTie.on('click', '.reply-one-edit', function(){
                var id = $(this).attr('data-id');
                if($(this).attr('data-check') == '1') {

                    $(this).attr('data-check', '0');
                    $(".delete-"+ id).remove();
                } else {
                    $('.reply input[name=at]').val($(this).attr('data-at'));
                    $('.reply input[name=parent_id]').val(id);

                    $(this).attr('data-check', '1');

                    var html ='<li class="edit-container delete-'+ id +'">';
                    html += $(".reply").html();
                    html += '</li>';
                    $(this).parents('.reply-' + id).after(html);
                    $('.abc').click();
                }
            });

            comTie.on('click', '.reply-two-edit', function(){
                var id = $(this).attr('data-id');

                if($(this).attr('data-check') == '1') {
                    $(this).attr('data-check', '0');
                    $(".delete-"+ id).remove();
                } else {
                    $('.reply input[name=at]').val($(this).attr('data-at'));
                    $('.reply input[name=parent_id]').val($(this).attr('data-pid'));

                    $(this).attr('data-check', '1');

                    var html ='<li class="share clearfix delete-'+ id +' "><div class="sh-l fl"><i></i></div><div class="sh-r fr edit-container"> ';
                    html += $(".reply").html();
                    html += '</div></li>';
                    $(this).parents('.reply-' + id).after(html);
                    $('.abc').click();
                }
            });

            //评论点赞
            comTie.on('click', '.thumbs', function(){
                var numClass = $(this).children(".num");
                var num = parseInt(numClass.text());
                var _this = $(this);

                if (! locked) {
                    return false;
                }

                locked = false;

                $.ajax({
                    url: $(this).attr('data-href'),
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

                        }else  if(res.code != 0) {
                            swal(res.data, '', 'error');
                        } else {

                            if(res.data == true) {
                                _this.children("i").addClass('default');
                                numClass.text(num + 1);
                            } else {
                                _this.children("i").removeClass('default');
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

            //评论删除
            comTie.on('click', '.delete-reply', function(){
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
                                url: _this.attr('data-href'),
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
                                        _this.parents('li').remove();
                                    }
                                    locked = true;
                                },
                                error:function () {
                                    locked = true;
                                }

                            });

                        }
                );
            })

        });
    </script>
@stop
