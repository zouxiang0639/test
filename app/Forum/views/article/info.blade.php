@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
@stop

@section('content')
    <div class="tie-inner">
        <div class="wm-850">
            <div class="inner-info">
                <p>帖子ID : {!! $info->id !!}</p>
                <p>发帖人 : 就近法子★ (注册时间:2013-10-17 登陆次数:1001)</p>
                <p>
                    <span>推荐 : 63</span>
                    <span>浏览 : 10019</span>
                    <span>回复: 25</span>
                </p>
                <p>
                    <span>发帖时间 : {{ $info->created_at }}</span>
                    <span>IP : 118.220.***.248</span>
                </p>
            </div>
        </div>
    </div>

    <div class="art-info">
        <div class="wm-850">
            <div class="art-con">
                <p class="tit">{{ $info->title }}</p>
                <div class="con-in">
                    <p style="font-size: 14px;color: #000; line-height: 36px;">1、</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">三个小孩在一起聊天说什么东西最毒！</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">小孩甲：“蚊子最毒，我哥的手被蚊子叮了一下，又红又痒。”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">小孩乙：“黄蜂最毒，我哥哥被黄蜂蛰了一下脸，现在还是又肿又痛。”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">小孩丙想了半天，说：“我也不知道什么东西扎了我姐，她肚子肿的又圆又大！”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">2、</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">妻子外出讨债，几个月后却空手而归。</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">老公生气地说：“你真无能！”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">妻子不服地说：“我虽然没有要到钱，但老板的孩子被我当了人质！”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">老公大喜，问道：“人呢？” 妻子一拍肚子，说：“关在里面了！”</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">3、</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">同桌把QQ名改为“你爹临死前”后加了我们班主任。</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">于是班主任的QQ就经常被提示：</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">你爹临死前请求加您为好友。</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">你爹临死前邀请您玩抢车位。</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">你爹临死前赠送了你QQ秀。</p>
                    <p style="font-size: 14px;color: #000; line-height: 36px;">你爹临死前偷了您的菜。</p>

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