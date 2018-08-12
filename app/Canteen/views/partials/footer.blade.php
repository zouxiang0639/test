<nav class="bar bar-tab">
    <!--<a class="tab-item external " href="{:Url('/wechat/index/index')}">-->
    <a class="tab-item" href="{!! route('c.member') !!}">
        <span class="icon icon-nav-user"></span>
        <span class="tab-label">会员中心</span>
    </a>
    <a class="tab-item" href="{!! route('c.canteen.meal') !!}">
        <span class="icon icon-nav-more"></span>
        <span class="tab-label">点餐</span>
    </a>
    <a class="tab-item external" href="{!! route('c.canteen.takeout') !!}">
        <span class="icon icon-nav-product "></span>
        <span class="tab-label">外卖</span>
    </a>
</nav>
