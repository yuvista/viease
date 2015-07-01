@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">素材管理</h2>
    </div>
    <ul class="nav nav-tabs min-with-md">
        <li role="presentation" class="active">
            <a href="#image">图片</a>
        </li>
        <li role="presentation">
            <a href="#video">视频</a>
        </li>
        <li role="presentation">
            <a href="#voice">音频</a>
        </li>
        <li role="presentation">
            <a href="#article">图文</a>
        </li>
    </ul>
    <div class="well">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="image">
                <div class="panel panel-default">
                    <div class="panel-heading with-md-button">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title">图片库 <small>共 <span class="count">0</span> 张图片</small></h3>
                            </div>
                            <div class="col-md-6">
                                <button class="pull-right btn btn-success upload-image"><i class="ion-plus"></i> 上传图片</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body popup-layer empty-listener row images-container ajax-loading"></div>
                    <div class="pagination-bar">
                        <hr>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="video">
                <div class="panel panel-default">
                    <div class="panel-heading with-md-button">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title">视频库 <small>共 <span class="count">0</span> 个视频</small></h3>
                            </div>
                            <div class="col-md-6">
                                <button class="pull-right btn btn-success"><i class="ion-plus"></i> 上传视频</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body popup-layer empty-listener row videos-container video-list-thumbs ajax-loading"></div>
                    <div class="pagination-bar">
                        <hr>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="voice">
                <div class="panel panel-default">
                    <div class="panel-heading with-md-button">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title">音频库 <small>共 <span class="count">0</span> 条音频</small></h3>
                            </div>
                            <div class="col-md-6">
                                <button class="pull-right btn btn-success"><i class="ion-plus"></i> 上传音频</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body popup-layer empty-listener row voices-container ajax-loading"></div>
                    <div class="pagination-bar">
                        <hr>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="article">
                <div class="panel panel-default">
                    <div class="panel-heading with-md-button">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title">图文库 <small>共 <span class="count">0</span> 篇文章</small></h3>
                            </div>
                            <div class="col-md-6">
                                <button class="pull-right btn btn-success"><i class="ion-plus"></i> 创建图文</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body popup-layer empty-listener row articles-container ajax-loading"></div>
                    <div class="pagination-bar">
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/plain" id="no-content-template">
    <div class="blankslate spacious">
        <h3><i class="ion-ios-information"></i> 无内容</h3>
        <p>请点击右上角按钮添加内容</p>
    </div>
</script>
<script type="text/plain" id="image-item-template">
    <div class="col-xs-6 col-sm-3">
        <a href="<%= url %>" target="_blank" class="popup">
          <img src="<%= url %>" alt="" class="img-responsive">
        </a>
    </div>
</script>
<script type="text/plain" id="video-item-template">
    <div class="col-xs-6 col-sm-3 video-card">
        <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
            <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
            <h2>北京中关村大街理想国际大厦</h2>
            <span class="icon ion-ios-play"></span>
            <!-- <span class="duration">03:15</span>-->
        </a>
    </div>
</script>
<div id="queue"></div>
@stop

@section('js')
<script src="{{ asset('js/admin/repos/material.js') }}"></script>
<script src="{{ asset('js/plugins/plupload/js/plupload.full.min.js') }}"></script>
<script src="{{ asset('js/uploader.js') }}"></script>
<script>
    $(function(){
        var emptyContentTemplate = _.template($('#no-content-template').html());

        var templates = {
            image: _.template($('#image-item-template').html()),
            video: _.template($('#video-item-template').html()),
        };

        var containers = {
            image: $('.images-container'),
            video: $('.videos-container'),
            voice: $('.voices-container'),
            article: $('.articles-container')
        };

        var imageUploader = uploader.make('.upload-image', 'image', function(){
            console.log(arguments);
        });

        console.log(imageUploader);

        // 当无内容时显示“无内容”提示
        $('.panel-body popup-layer.empty-listener').ifEmpty(function($el){
            $el.html(emptyContentTemplate()).addClass('no-content');;
        });

        /**
         * 通用加载资源
         *
         * @param {String} $type
         * @param {Int} $page
         *
         * @return {Void}
         */
        function load($type, $page) {
            console.log($type);
            var $request = {
                type: $type,
                page: $page,
            };

            Repo.material.lists($request, function($items){
                var template = templates[$type];
                var container = containers[$type];

                container.html('');

                _.each($items, function($item) {
                    if(window.__page == 1){
                        container.find('.blankslate').remove();
                    }
                    container.append(template($item));
                });

                pagination($type);
            });
        }

        Repo.material.summary(function($summary){
            _.mapObject($summary, function($count, $type) {
                $('#' + $type + ' .count').html($count);
            });
        });

        load('image');
        load('video');

        function pagination($type) {
            new Pager('#' + $type + ' .pagination-bar', {
                total: window.last_response.last_page,
                current: window.last_response.current_page,
                onChange: function($page){
                    console.log('loading page:'+$page);
                    load($type, $page);
                }
            });
        }

        $('.load-more button').on('click', function(){
            var $type = $(this).closest('.tab-pane').attr('id');
            load($type);
        });
    })
</script>
@stop