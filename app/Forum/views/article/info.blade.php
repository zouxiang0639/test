@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
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
                    <span>推荐 : {{ $info->recommend }}</span>
                    <span>浏览 : {{ $info->browse }}</span>
                    <span>回复: {{ $info->reply }}</span>
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
                <p class="source">来源：网易</p>
                <div class="link clearfix">
                    <div class="address fl">复制本帖地址<a href="javascript:void(0)"><i></i> http://kongdi.com/humor_1215</a></div>
                    <div class="share fr">
                        <a class="col" href="javascript:void(0)"><i></i>收藏</a>
                        <a class="pink" href="javascript:void(0)"><i></i>一键分享</a>
                        <p class="some">
                            分享至：
                            <a class="sm1" href="javascript:void(0)"></a>
                            <a class="sm2" href="javascript:void(0)"></a>
                            <a class="sm3" href="javascript:void(0)"></a>
                            <a class="sm4" href="javascript:void(0)"></a>
                            <a class="sm5" href="javascript:void(0)"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fabulous">
        <div class="wm-850">
            <div class="fabulous-con">
                <a class="are" href="javascript:void(0)">举报!</a>

                <p class="thumbs-up thumbs {!! in_array($userId, $info->thumbs_up) ? "default" : "" !!}" data-href="{!! route('f.article.thumbsUp',['id' => $info->id]) !!}" href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-up"></i>
                    <span class="num">{!! count($info->thumbs_up) !!}</span>
                </p>

                <p class=" thumbs-down thumbs {!! in_array($userId, $info->thumbs_down) ? "default" : "" !!}" data-href="{!! route('f.article.thumbsDown',['id' => $info->id]) !!}" href="javascript:void(0)">
                    <i class="fa fa-thumbs-o-down"></i>
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

                    </ul>
                </div>
                <div class="page">
                    <a id="reply-page">加载更多</a>
                </div>
                <div class="edit-container">

                </div>

                <div style="display: none">
                    <div class="reply">
                        <div class="con">
                            <form class="reply-form">
                                <input type="hidden" name="article_id" value="{!! $info->id !!}">
                                <input type="hidden" name="at" value="0">
                                <input type="hidden" name="parent_id" value="0">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="tea">
                                    <textarea name="contents"></textarea>
                                </div>
                                <div class="opt">
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
                <div class="new-list">
                    <ul class="clearfix">
                        <li><a href="javascript:void(0)"><img src="img/pic2.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic2.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic3.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic4.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic5.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic5.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic4.jpg" alt="" title="" /></a></li>
                        <li><a href="javascript:void(0)"><img src="img/pic4.jpg" alt="" title="" /></a></li>
                    </ul>
                </div>
                <div class="new-tit"><i></i></div>
                <table class="new-table">
                    <thead>
                    <tr>
                        <th width="55">编号</th>
                        <th width="515">题目</th>
                        <th width="95">ID</th>
                        <th width="95">浏览/推荐</th>
                        <th width="90">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td width="55">11</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-1"></i>生娃已有六个月，目前为止没有一次性生活，这样正常吗？会不..</a></td>
                        <td width="95">清歌莫断肠</td>
                        <td width="95">
                            537533
                            <span class="red">2445</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">12</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-2"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）<span class="blue">(20)</span></a></td>
                        <td width="95">龙的传人</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">13</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-3"></i>老婆精神出轨，我该原谅她吗？<span class="blue">(20)</span></a></td>
                        <td width="95">jasonlin648</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">11</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-1"></i>生娃已有六个月，目前为止没有一次性生活，这样正常吗？会不..</a></td>
                        <td width="95">清歌莫断肠</td>
                        <td width="95">
                            537533
                            <span class="red">2445</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">12</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-2"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）<span class="blue">(20)</span></a></td>
                        <td width="95">龙的传人</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">13</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-3"></i>老婆精神出轨，我该原谅她吗？<span class="blue">(20)</span></a></td>
                        <td width="95">jasonlin648</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">11</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-1"></i>生娃已有六个月，目前为止没有一次性生活，这样正常吗？会不..</a></td>
                        <td width="95">清歌莫断肠</td>
                        <td width="95">
                            537533
                            <span class="red">2445</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">12</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-2"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）<span class="blue">(20)</span></a></td>
                        <td width="95">龙的传人</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">13</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-3"></i>老婆精神出轨，我该原谅她吗？<span class="blue">(20)</span></a></td>
                        <td width="95">jasonlin648</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">11</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-1"></i>生娃已有六个月，目前为止没有一次性生活，这样正常吗？会不..</a></td>
                        <td width="95">清歌莫断肠</td>
                        <td width="95">
                            537533
                            <span class="red">2445</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">12</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-2"></i>朱棣与朱允文的相爱相杀（原创历史小说，每日更新中）<span class="blue">(20)</span></a></td>
                        <td width="95">龙的传人</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">13</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-3"></i>老婆精神出轨，我该原谅她吗？<span class="blue">(20)</span></a></td>
                        <td width="95">jasonlin648</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    <tr>
                        <td width="55">13</td>
                        <td class="l" width="515"><a href="javascript:void(0)"><i class="i-3"></i>老婆精神出轨，我该原谅她吗？<span class="blue">(20)</span></a></td>
                        <td width="95">jasonlin648</td>
                        <td width="95">
                            545451
                            <span class="red">698</span>
                        </td>
                        <td width="90">
                            2018/5/1<br />
                            16:00
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="com-page">
                    <a class="home" href="javascript:void(0)"></a>
                    <a class="prev" href="javascript:void(0)"></a>
                    <a href="javascript:void(0)">1</a>
                    <a href="javascript:void(0)">2</a>
                    <a href="javascript:void(0)">3</a>
                    <a href="javascript:void(0)">4</a>
                    <a href="javascript:void(0)">5</a>
                    <a href="javascript:void(0)">6</a>
                    <a href="javascript:void(0)">7</a>
                    <a href="javascript:void(0)">8</a>
                    <a href="javascript:void(0)">9</a>
                    <a href="javascript:void(0)">10</a>
                    <a class="next" href="javascript:void(0)"></a>
                    <a class="end" href="javascript:void(0)"></a>
                </div>
            </div>
        </div>
    </div>

    @include('forum::partials.ad')
@stop

@section('script')
    <script>

        $(function(){
            var locked = true;

            /**
             *  点赞
             */
            $(".com-tie").on('click', '.reply—submit', function(){
                var _this = $(this);

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
                        if(res.code != 0) {
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
                            locked = true;
                        } else {

                            if(res.data == true) {
                                _this.addClass('default');
                                numClass.text(num + 1);
                            } else {
                                _this.removeClass('default');
                                numClass.text(num - 1);
                            }
                            locked = true;
                        }
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
                            $('.page').html(res.data);
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
            $(".com-tie").on('click', '.reply-show-child', function(){
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

            $(".com-tie").on('click', '.reply-one-edit', function(){
                var id = $(this).attr('data-id');
                if($(this).attr('data-check') == '1') {

                    $(this).attr('data-check', '0');
                    $(".delete-"+ id).remove();
                } else {
                    $('.reply input[name=at]').val($(this).attr('data-at'));
                    $('.reply input[name=parent_id]').val(id);

                    $(this).attr('data-check', '1');

                    var html ='<li class="edit-container delete-'+ id +'"><div class="con">';
                    html += $(".reply").html();
                    html += '</div></li>';
                    $(this).parents('.reply-' + id).after(html);
                }

            });

            $(".com-tie").on('click', '.reply-two-edit', function(){
                var id = $(this).attr('data-id');

                if($(this).attr('data-check') == '1') {
                    $(this).attr('data-check', '0');
                    $(".delete-"+ id).remove();
                } else {
                    $('.reply input[name=at]').val($(this).attr('data-at'));
                    $('.reply input[name=parent_id]').val($(this).attr('data-pid'));

                    $(this).attr('data-check', '1');

                    var html ='<li class="share clearfix delete-'+ id +' "><div class="sh-l fl"><i></i></div><div class="sh-r fr edit-container"> <div class="con">';
                    html += $(".reply").html();
                    html += '</div></div></li>';
                    $(this).parents('.reply-' + id).after(html);
                }

            });

            $(".com-tie").on('click', '.thumbs', function(){


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
                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {

                            if(res.data == true) {
                                _this.children("i").addClass('default');
                                numClass.text(num + 1);
                            } else {
                                _this.children("i").removeClass('default');
                                numClass.text(num - 1);
                            }
                            locked = true;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });
            })



        });


    </script>
@stop
