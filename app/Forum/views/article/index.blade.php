@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/list.css") !!}" />
@stop

@section('content')
    <div class="list-container">
        <div class="wm-850">
            <div class="list">
                <div class="list-txt">
                    <p style="color: #cccccc;line-height:20px;">这里是幽默板块</p>
                    <p style="color: #cccccc;line-height:20px;">您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容</p>
                    <p style="color: #cccccc;line-height:20px;">其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块</p>
                </div>
                <div class="list-other">
                    点击查看幽默板块→
                    <a href="javascript:void(0)">热门</a>
                    <a href="javascript:void(0)">最新</a>
                </div>
            </div>
        </div>
    </div>
    <div class="com-new">
        <div class="wm-850">
            <div class="new-container">
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
@stop