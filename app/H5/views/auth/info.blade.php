@extends('h5::layouts.master')
@section('content')
  <div class="pages">
      <div class="post-con">
          <div class="post-tit">空地社区用户注册协议</div>

          <div class="post-txt">

              <div class="tep3">
                  {!!  Forum::fragment()->get(4, 'contents') !!}
              </div>

          </div>
      </div>
  </div>
@stop

@section('script')
@stop