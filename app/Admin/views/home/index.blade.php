@extends('admin::layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>  <i class="fa fa-users"></i></h3>
                    <p>管理员</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{!! route('m.user.list') !!}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3> <i class="fa fa-user"></i></h3>
                    <p>角色</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{!! route('m.role.list') !!}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>  <i class="fa fa-ban"></i></h3>
                    <p>权限</p>
                </div>
                <div class="icon">
                    <i class="fa fa-ban"></i>
                </div>
                <a href="{!! route('m.permissions.list') !!}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3> <i class="fa fa-bars"></i></h3>
                    <p>菜单</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <a href="{!! route('m.menu.list') !!}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
@stop

@include('admin::partials.toastr')