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
                <a class="good" href="javascript:void(0)"><i></i><span>152</span></a>
                <a class="bad" href="javascript:void(0)"><i></i><span>20</span></a>
            </div>
        </div>
    </div>

    <div class="com-new">
        <div class="wm-850">
            <div class="new-container new-inner">
                <div class="new-inner-tit">*超过10赞底色变为浅绿色，超过100赞底色变为绿色，弱数超过赞数10个底色变为浅红色，楼主回复底色为黄色</div>
                <div class="com-tie">
                    <ul>
                        <li class="color-1">
                            <div class="top">
                                <p class="left"><b>江南小雨</b>(2018/05/20 16:00) 211.38.***.118 </p>
                                <p class="right">
                                    <a class="delete" href="javascript:void(0)"><i></i></a>
                                    <a class="praise" href="javascript:void(0)"><i></i>59</a>
                                    <a class="neg" href="javascript:void(0)"><i></i>0</a>
                                    <a class="review" href="javascript:void(0)"><i></i></a>
                                    <a class="inf" href="javascript:void(0)"><i></i></a>
                                </p>
                            </div>
                            <div class="con">
                                <p>自己坐沙发 搞笑。。</p>
                            </div>
                        </li>
                        <li class="color-2">
                            <div class="top">
                                <p class="left"><b>江南小雨</b>(2018/05/20 16:00) 211.38.***.118 </p>
                                <p class="right">
                                    <a class="delete" href="javascript:void(0)"><i></i></a>
                                    <a class="praise" href="javascript:void(0)"><i></i>59</a>
                                    <a class="neg" href="javascript:void(0)"><i></i>0</a>
                                    <a class="review" href="javascript:void(0)"><i></i></a>
                                    <a class="inf" href="javascript:void(0)"><i></i></a>
                                </p>
                            </div>
                            <div class="con">
                                <p>自己坐沙发 搞笑。。</p>
                            </div>
                            <a class="other" href="javascript:void(0)">回复 15<i></i></a>

                        </li>
                        <li class="share color-3 clearfix">
                            <div class="sh-l fl">
                                <i></i>
                            </div>
                            <div class="sh-r fr">
                                <div class="top">
                                    <p class="left"><b>江南小雨</b>(2018/05/20 16:00) 211.38.***.118 </p>
                                    <p class="right">
                                        <a class="delete" href="javascript:void(0)"><i></i></a>
                                        <a class="praise" href="javascript:void(0)"><i></i>59</a>
                                        <a class="neg" href="javascript:void(0)"><i></i>0</a>
                                        <a class="review" href="javascript:void(0)"><i></i></a>
                                    </p>
                                </div>
                                <div class="con">
                                    <p>自己坐沙发 搞笑。。</p>
                                </div>
                            </div>
                        </li>
                        <li class="share color-4 clearfix">
                            <div class="sh-l fl">
                                <i></i>
                            </div>
                            <div class="sh-r fr">
                                <div class="top">
                                    <p class="left"><b>江南小雨</b>(2018/05/20 16:00) 211.38.***.118 </p>
                                    <p class="right">
                                        <a class="delete" href="javascript:void(0)"><i></i></a>
                                        <a class="praise" href="javascript:void(0)"><i></i>59</a>
                                        <a class="neg" href="javascript:void(0)"><i></i>0</a>
                                        <a class="review" href="javascript:void(0)"><i></i></a>
                                    </p>
                                </div>
                                <div class="con">
                                    <p>自己坐沙发 搞笑。。</p>
                                </div>
                            </div>
                        </li>
                        <li class="color-5">
                            <div class="top">
                                <p class="left"><b>江南小雨</b>(2018/05/20 16:00) 211.38.***.118 </p>
                                <p class="right">
                                    <a class="delete" href="javascript:void(0)"><i></i></a>
                                    <a class="praise" href="javascript:void(0)"><i></i>59</a>
                                    <a class="neg" href="javascript:void(0)"><i></i>0</a>
                                    <a class="review" href="javascript:void(0)"><i></i></a>
                                    <a class="inf" href="javascript:void(0)"><i></i></a>
                                </p>
                            </div>
                            <div class="con">
                                <p>自己坐沙发 搞笑。。</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="page">
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
                <div class="edit-container">
                    <div class="con">
                        <div class="tea">
                            <textarea></textarea>
                        </div>
                        <div class="opt">
                            <a class="img" href="javascript:void(0)"><i></i></a>
                            <a class="txt" href="javascript:void(0)">回复</a>
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