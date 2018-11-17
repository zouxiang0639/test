@extends('h5::layouts.master')

@section('content')
    <div class="des-info">
        <div class="article">
            <div class="title"><h1>儿子，饭好啦，快出来吃饭~~~</h1></div>
            <div class="con">
                <p>
                    @if($checkAuth && is_null($info->deleted_at))
                        <a style="margin-left: 40px; color: #337ab7;" title="编辑" href="{!! route('f.article.edit', ['id' => $info->id]) !!}">
                            <i class="fa fa-edit"></i>编辑
                        </a>
                        <a title="删除" class="article—delete" style="color: #337ab7;"  href="javascript:;" data-url="{!! route('f.article.delete', ['id' => $info->id]) !!}">
                            <i class="fa fa-trash"></i>删除
                        </a>
                    @endif
                </p>
                <p>
                    <span>帖子ID : {!! $info->id !!}</span>
                    <span>发帖人 :<a href="{!! route('f.space.index', ['user_id' => $info->issuer]) !!}"><i>{{ $info->issuers->name  }}</i></a>(注册时间:{{ mb_substr($info->issuers->created_at, 0, 10) }} 登陆次数:{{ $info->issuers->login_num }})</span>
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

            <div class="show-op clearfix">

                <span value="{!! route('h.article.info', ['id'=> $info->id])  !!}" class="copyVideo reprint" onclick="copyVideoUrl(event)">
                            复制本帖地址
                        <i class="icon-copy"></i>
                        </span>
                <p>
                    <a href="javascript:void(0)">举报！</a>
                    <a href="javascript:void(0)"><i class="coll-ico"></i>收藏</a>
                    <a href="javascript:void(0)">分享</a>
                </p>
            </div>
        </div>
        <div class="zan-show">
            <div class="con">
                <a class="gd" href="javascript:void(0)"><i></i>10</a>
                <a class="bad" href="javascript:void(0)"><i></i>0</a>
            </div>
            <p>*10赞以上变浅绿色，20赞以上变绿色，弱数超过赞数10个变浅红色，楼主回复为蓝色</p>
        </div>
        <div class="reply-show">
            <ul>
                <li>
                    <div class="box">
                        <div class="con-1 clearfix">
                            <p class="fl"><b>Gardener</b>(2018-10-02&nbsp;00:58)</p>
                            <p class="fr">
                                <a class="ico-1" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-2" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-3" href="javascript:void(0)"></a>
                                <a class="ico-4" href="javascript:void(0)"></a>
                            </p>
                        </div>
                        <div class="con-2">饭呢。。？</div>
                    </div>
                </li>
                <li class="hover">
                    <div class="box">
                        <div class="con-1 clearfix">
                            <p class="fl"><b>Gardener</b>(2018-10-02&nbsp;00:58)</p>
                            <p class="fr">
                                <a class="ico-1" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-2" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-3" href="javascript:void(0)"></a>
                                <a class="ico-4" href="javascript:void(0)"></a>
                            </p>
                        </div>
                        <div class="con-2">这不是我妈。。。</div>
                        <div class="con-3 clearfix">
                            <span>回复1<i></i></span>
                        </div>
                    </div>
                </li>
                <li class="clearfix">
                    <div class="relpy-bz fl"><i></i></div>
                    <div class="box box-d fl">
                        <div class="con-1 clearfix">
                            <p class="fl"><b>Gardener</b>(2018-10-02&nbsp;00:58)</p>
                            <p class="fr">
                                <a class="ico-1" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-2" href="javascript:void(0)"><i></i>0</a>
                                <a class="ico-3" href="javascript:void(0)"></a>
                                <a class="ico-4" href="javascript:void(0)"></a>
                            </p>
                        </div>
                        <div class="con-2">都一样的通常等10分钟</div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="reply-push">

            <textarea></textarea>

            <div class="btn clearfix">
                <a href="javascript:void(0)">发表回复</a>
                <a class="xinfo" href="javascript:void(0)"><i></i></a>
            </div>
        </div>

    </div>
@stop
@section('script')
    <script>

        $(function(){
           $('.content img').removeAttr("height").removeAttr("style").removeAttr('width');

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