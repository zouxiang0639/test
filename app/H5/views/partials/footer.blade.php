<div class="footer">
    <div class="go-top">
        <i class="icon-img" id="scroll_top"></i>
    </div>
    <div class="ft-link">
        <a class="check-auth" href="{!! route('h.feedback.feedback') !!}">增设板块建议</a>
        <a class="check-auth" href="{!! route('h.feedback.operate') !!}">给运营组的建议</a>
        <a class="check-auth" href="{!! route('h.feedback.moderator') !!}">版主申请</a>
        <a class="check-auth" href="{!! route('h.feedback.appeals') !!}">申诉区</a>
    </div>
    <p class="copyright">网站试运营，欢迎提出意见&nbsp;&nbsp;2018&nbsp;longdi&nbsp;All&nbsp;Rights&nbsp;Reserved
        </p>
    <p class="copyright">
        <a target="_blank" href="http://www.miitbeian.gov.cn/"> {!! config('config.icp') !!}</a>
        @if(config('app.env') == 'production')
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1275061811'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1275061811%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
        @endif
    </p>
</div>