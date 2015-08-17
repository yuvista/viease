@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">菜单管理 <div class="pull-right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="启用或停用菜单">停用</button></div></h2>
    </div>
    <div class="well row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">自定义菜单 <a href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="创建一个菜单" class="add-menu-item pull-right"><i class="ion-android-add icon-md" ></i></a></div>
                <div class="list-group">
                    <div class="menus no-menus resizeable"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">自定义菜单</div>
                <div class="panel-body response-content">
                    <div class="blankslate spacious">你可以从左边创建一个菜单并设置响应内容。</div>
                </div>
            </div>
        </div>
        <div class="buttons col-md-12 text-center">
            <hr>
            <button class="btn btn-success submit-menu">提交</button>
            <button class="btn btn-default">重置</button>
        </div>
    </div>
</div>
<!--测试使用 使用完成后删除-->
<br>
<br>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<a href="javascript:;" id="save">菜单保存样例</a>
<!--End-->
<script type="text/template" id="no-menus-content-template">
    <div class="blankslate spacious">
        <p>尚未配置菜单</p>
        <div><a href="javascript:;" class="add-menu-item">点此立即创建</a></div>
    </div>
</script>
<script type="text/template" id="menu-item-template">
    <div class="list-group-item menu-item" id="<%= menu.id %>" data-parent-id="<%= menu.parent %>">
        <div class="menu-item-heading">
            <span class="menu-item-name"><%= menu.name %></span>
            <div class="actions pull-right">
                <a href="javascript:;" class="edit" title=""><i class="ion-ios-compose-outline"></i></a>
                <a href="javascript:;" class="add-sub" ><i class="ion-ios-plus-empty"></i></a>
                <a href="javascript:;" class="trash" ><i class="ion-ios-trash-outline"></i></a>
            </div>
        </div>
        <div class="list-group sub-buttons no-menus"></div>
    </div>
</script>
<script type="text/template" id="menu-item-form-template">
    <div class="list-group-item menu-item">
        <form action="" method="post" accept-charset="utf-8" class="menu-item-form">
            <div class="form-group">
                <input type="text" name="name" placeholder="" class="form-control" value="<% if (typeof name != 'undefined') { %><%= name %><% } %>">
            </div>
            <input type="hidden" name="id" value="<% if (typeof id != 'undefined') { %><%= id %><% } %>">
            <input type="hidden" name="parent" value="<% if (typeof parent != 'undefined') { %><%= parent %><% } %>">
            <button type="submit" class="btn btn-xs btn-success">保存</button>
            <button type="button" class="btn btn-xs btn-danger cancel-do">取消</button>
        </form>
    </div>
</script>

<script id="response-content-picker" class="hidden" type="text/plain">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#text-tab-content" data-type="text" aria-controls="text-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-information-outline"></i> 文字</a></li>
        <li role="presentation"><a href="#url-tab-content" data-type="url" aria-controls="url-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-monitor"></i> 网页</a></li>
        <li role="presentation"><a href="#image-tab-content" data-type="image" aria-controls="image-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-photos-outline"></i> 图片</a></li>
        <li role="presentation"><a href="#video-tab-content" data-type="video" aria-controls="video-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-videocam-outline"></i> 视频</a></li>
        <li role="presentation"><a href="#voice-tab-content" data-type="voice" aria-controls="voice-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-volume-high"></i> 声音</a></li>
        <li role="presentation"><a href="#article-tab-content" data-type="article" aria-controls="article-tab-content" role="tab" data-toggle="tab"><i class="ion-ios-paper-outline"></i> 图文</a></li>
    </ul>

    <!-- Tab panes -->
    <form action="" method="post" accept-charset="utf-8" class="form-horizontal" id="response-content-form">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="text-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="message-editor"></div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="url-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="well row">
                        <label class="col-md-3 control-label">目标网址：</label>
                        <div class="col-md-9">
                            <input type="text" name="url" value="" class="form-control" placeholder="http://viease.com">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="image-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="text-center response-content-picker">
                        <div class="preview-content">

                        </div>
                        <div class="btns">
                            <a href="javascript:;" class="btn btn-success image-picker"><i class="ion-plus"></i> 从媒体库选择</a>
                            <input type="hidden" name="image_media_id" value="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="video-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="text-center response-content-picker">
                        <div class="preview-content">

                        </div>
                        <div class="btns">
                            <a href="javascript:;" class="btn btn-success video-picker"><i class="ion-plus"></i> 从媒体库选择</a>
                            <input type="hidden" name="video_media_id" value="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="voice-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="text-center response-content-picker">
                        <div class="preview-content"></div>
                        <div class="btns">
                            <a href="javascript:;" class="btn btn-success voice-picker"><i class="ion-plus"></i> 从媒体库选择</a>
                            <input type="hidden" name="voice_media_id" value="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="article-tab-content">
                <div class="result-container-wrapper" style="display:none">
                    <div class="result-container"></div>
                    <div>
                        <button type="" class="btn btn-default edit-btn">编辑</button>
                    </div>
                </div>
                <div class="form-area">
                    <div class="text-center response-content-picker">
                        <div class="preview-content"></div>
                        <div class="btns">
                            <a href="javascript:;" class="btn btn-success article-picker"><i class="ion-plus"></i> 从媒体库选择</a>
                            <input type="hidden" name="article_media_id" value="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-btns">
            <input type="hidden" name="type" value="">
            <button type="" class="btn btn-success">确定</button>
        </div>
    </form>
</script>

@stop

@section('js')
<script>
    $(function(){
        $('#save').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/menu/store',
              data: {
                    menus:[
                        {
                            name:"百度链接",
                            type:"view",
                            value:"http://www.baidu.com"
                        },
                        {
                            name:"带有下级",
                            sub_button:[
                                {
                                    name:"新浪连接",
                                    type:"view",
                                    value:"http://www.sina.com"
                                },
                                {
                                    name:"给你个图",
                                    type:"media",
                                    value:"MEDIA_XXXXXXX11"
                                },
                                {
                                    name:"看点文字",
                                    type:"pic_sysphoto",
                                    value:"xxxx"
                                }
                            ]
                        },
                        {
                            name:"一个图文",
                            type:"media",
                            value:"MEDIA_XXXXXXX",
                        }
                    ]
                },
            });
        });
    });
require(['pages/menu']);
</script>
@stop
