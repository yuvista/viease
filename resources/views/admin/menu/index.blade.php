@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">菜单管理</h2>
    </div>
    <div class="well row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">自定义菜单 <a href="#new-menu-modal" data-toggle="modal" data-target="#new-group-modal" class="pull-right"><i class="ion-android-add icon-md"></i></a></div>
                <div class="list-group">
                    <div class="list-group-item blankslate spacious">尚未配置菜单</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">自定义菜单</div>
                <div class="panel-body">
                    <div class="blankslate spacious">你可以从左边创建一个菜单并设置响应内容。</div>
                </div>
        </div>
    </div>
</div>
@stop