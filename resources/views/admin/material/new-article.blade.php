@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">素材管理</h2>
    </div>
    <ul class="nav nav-tabs min-with-md">
        <li role="presentation">
            <a href="#image">图片</a>
        </li>
        <li role="presentation">
            <a href="#video">视频</a>
        </li>
        <li role="presentation">
            <a href="#voice">音频</a>
        </li>
        <li role="presentation">
            <a href="#article" class="active">图文</a>
        </li>
    </ul>
    <div class="well">
        <div class="col-md-4">

        </div>
        <div class="col-md-8">
            <form action="" method="POST" role="form">
                    <div class="form-group">
                    <label>标题</label>
                        <input type="text" name="title" id="input" class="form-control" value="" required="required" pattern="" title="">
                    </div>
                    <div class="form-group">
                    <label>作者<small>(选填)</small></label>
                        <input type="text" name="title" id="input" class="form-control" value="" required="required" pattern="" title="">
                    </div>

                    <div class="form-group">
                    <label>摘要<small>(选填，该摘要只在发送图文消息为单条时显示)</small></label>
                        <textarea name="" id="inputContent" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                    <label>正文<small></small></label>
                        <script id="container" name="content" style="width:100%;" type="text/plain"></script>
                    </div>

                    <div class="form-group">
                    <label>原文链接<small></small></label>
                        <input type="text" name="title" id="input" class="form-control" value="" required="required" pattern="" title="">
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('js/plugins/ueditor/themes/viease/css/ueditor-viease.css') }}">
@stop

@section('js')
<script src="{{ asset('js/admin/repos/material.js') }}"></script>
<script src="{{ asset('js/plugins/plupload/js/plupload.full.min.js') }}"></script>
<script>window.UEDITOR_HOME_URL = "{{ asset('js/plugins/ueditor/') }}/";</script>
<script type="text/javascript" src="{{ asset('js/plugins/ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/ueditor/ueditor.all.min.js') }}"></script>
<script src="{{ asset('js/uploader.js') }}"></script>
<script>
    $(function(){
        var ue = UE.getEditor('container');
    })
</script>
@stop