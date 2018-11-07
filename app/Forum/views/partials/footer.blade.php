<div class="com-footer">
    <div class="wm-850 feedback-create">
        <p>
            <a href="{!! route('f.feedback.feedback') !!}">增设板块建议</a>
            <a href="{!! route('f.feedback.operate') !!}">给运营组的建议</a>
            <a href="{!! route('f.feedback.moderator') !!}">版主申请</a>
            <a href="{!! route('f.feedback.appeals') !!}">申诉区</a>
        </p>
        <p>
            <span> {!! Forum::fragment()->get(6, 'contents') !!}</span>
            @if(config('app.env') == 'production')
                <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1275061811'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1275061811%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
            @endif
        </p>
    </div>
</div>