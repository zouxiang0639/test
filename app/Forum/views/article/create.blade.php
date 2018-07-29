@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/post.css") !!}" />
@stop

@section('content')
    <div class="post-contianer">
        <div class="wm-850">
            <div class="post-con">
                <div class="post-tit">发表新帖</div>
                <div class="post-txt">
                    <div class="tep1 clearfix">
                        <p class="sel">
                            <label>选择板块:</label>
                            <select>
                                <option>烦恼</option>
                                <option>烦恼</option>
                                <option>烦恼</option>
                            </select>
                        </p>
                        <p class="ck"><input type="checkbox" id="check1" value="123" name="name" class="check"><label for="check1">匿名</label></p>
                    </div>
                    <div class="tep2">
                        <input type="text" placeholder="请填写标题" />
                    </div>
                    <div class="tep3">
                        <p class="link clearfix">
                            <a class="a-1" href="javascript:void(0)"></a>
                            <a class="a-2" href="javascript:void(0)"></a>
                            <a class="a-3" href="javascript:void(0)"></a>
                            <a class="a-4" href="javascript:void(0)"></a>
                            <a class="a-5" href="javascript:void(0)"></a>
                            <a class="a-6" href="javascript:void(0)"></a>
                            <a class="a-7" href="javascript:void(0)"></a>
                        </p>
                        <p class="area">
                            <textarea></textarea>
                        </p>
                        <p class="text">
                            <input type="text" placeholder="转载内容请填写原作者与来源，原创内容无需填写" />
                        </p>
                    </div>
                    <div class="tep4">
                        <a class="post-btn" href="javascript:void(0)">发表</a>
                        <a class="cancel-btn" href="javascript:void(0)">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop