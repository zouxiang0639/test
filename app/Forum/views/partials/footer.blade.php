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
        </p>
    </div>
</div>