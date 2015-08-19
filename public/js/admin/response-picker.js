define(['jquery', 'underscore', 'WeChatEditor', 'admin/media-picker'], function ($, _, WeChatEditor, MediaPicker) {
    var $defaults = {
        onChanged: function($item){
            console.log('picked', $item);
        },
    };

    var $tabs = [
                {type:"text",title:"文字",icon:"ion-ios-information-outline"},
                {type:"url",title:"网址",icon:"ion-ios-monitor"},
                {type:"image",title:"图片",icon:"ion-ios-photos-outline"},
                {type:"video",title:"视频",icon:"ion-ios-videocam-outline"},
                {type:"voice",title:"声音",icon:"ion-ios-volume-high"},
                {type:"article",title:"图文",icon:"ion-ios-paper-outline"}
            ];

    /**
     * ResponsePicker
     *
     * @param {String} $container
     * @param {Object} $options
     */
    function ResponsePicker ($container, $options) {
        if (!(this instanceof ResponsePicker)) return new ResponsePicker($element, $options);

        this.options = $options || {};

        for (var i in $defaults) {
          if (this.options[i] == null) {
            this.options[i] = $defaults[i];
          }
        }

        this.container = $($container);
        this.tabs = $tabs;

        this.init();
    }

    ResponsePicker.prototype.init = function () {
        this.createPicker();
        this.addListeners();
    }

    /**
     * 创建选择器控件
     */
    ResponsePicker.prototype.createPicker = function () {


        this.container.html('');
        this.container.append(this.getTabLinks());
        this.container.append(this.getTabContents());

        this.container.find('.tab-link:first').trigger('click');
    }

    ResponsePicker.prototype.getTabLinks = function(){
        var $template = _.template('<li role="presentation"><a href="#<%= type %>-tab-content" data-type="<%= type %>" aria-controls="<%= type %>-tab-content" role="tab" class="tab-link" data-toggle="tab"><i class="<%= icon %>"></i> <%= title %></a></li>');

        var $links = $('<ul class="nav nav-tabs" role="tablist"></ul>');

        var $items = '';

        _.each(this.tabs, function($item) {
            $items += $template($item);
        });

        $links.append($items);

        return $links;
    };

    ResponsePicker.prototype.getTabContents = function () {
        var $form = $('<form action="" method="post" accept-charset="utf-8" class="form-horizontal" id="response-content-form"></form>');

        var $tabContent = $form.append('<div class="tab-content"></div>').find('.tab-content');
        var $template = _.template('<div role="tabpanel" class="tab-pane" id="<%= tab.type %>-tab-content"><%= content %></div>');
        var $items = '';
        var $picker = this;

        _.each(this.tabs, function($item) {
            $items += $template({tab: $item, content: $picker.getTypeTabContent($item.type)});
        });

        $tabContent.append($items);

        return $tabContent;
    }

    ResponsePicker.prototype.getTypeTabContent = function ($type) {
        var $form;
        var $tabTemplate = _.template('<div class="panel panel-default md-top">'
                                        + '<div class="panel-body text-center">'
                                            + '<div class="result-container" style="display:none"></div>'
                                            + '<div class="preview-container" style="display:none"></div>'
                                            + '<div class="form-container"><%= form %></div>'
                                        + '</div>'
                                    + '</div>'
                                    + '<input type="hidden" name="type" value="" />'
                                    + '<button type="button" class="btn btn-success edit-btn">保存</button>');

        switch($type){
            case 'text':
                $form = '<div class="message-editor"></div>';
                break;
            case 'url':
                $form = '<div class="well row">'
                        + '<label class="col-md-3 control-label">目标网址：</label>'
                        + '<div class="col-md-9">'
                            + '<input type="text" name="url" value="" class="form-control" placeholder="http://viease.com">'
                        + '</div>'
                    + '</div>';
                break;
            case 'image':
            case 'video':
            case 'voice':
            case 'article':
            default:
                $form = '<div class="btns">'
                            + '<a href="javascript:;" class="btn btn-success '+ $type +'-picker"><i class="ion-plus"></i> 从媒体库选择</a>'
                            + '<input type="hidden" name="' + $type + '_media_id" value="" class="media-id form-control">'
                        + '</div>';
                break;
        }

        return $tabTemplate({form: $form});
    }

    ResponsePicker.prototype.addListeners = function () {
        var $picker = this;
        new WeChatEditor(this.container.find('.message-editor'), {textarea: 'text'});

        new MediaPicker('.image-picker', {type: 'image', onSelected: function($item){
            $picker.preview('image', $item);
        }});
        new MediaPicker('.video-picker', {type: 'video', onSelected: function($item){
            $picker.preview('video', $item);
        }});
        new MediaPicker('.voice-picker', {type: 'voice', onSelected: function($item){
            $picker.preview('voice', $item);
        }});
        new MediaPicker('.article-picker', {type: 'article', onSelected: function($item){
            $picker.preview('article', $item);
        }});
    }

    ResponsePicker.prototype.getCurrentTab = function () {
        return this.container.find('.tab-pane.active');
    }

    ResponsePicker.prototype.preview = function ($type, $data) {
        var $tab = this.getCurrentTab();

        $tab.find('.media-id').val($data.media_id);
        $tab.find('.preview-container').html(this.getPreviewItem($type, $data)).slideDown();
    }

    ResponsePicker.prototype.getPreviewItem = function ($type, $data) {
        var $mediaPreviewItem = _.template('<div class="media-preview"><%= item %></div>');

        switch($type){
            case 'text':
                $html = $data.text;
                break;
            case 'url':
                $html = $data.url;
                break;
            case 'image':
                $html = '<img src="'+$data.source_url+'">';
                break;
            case 'video':
                $html = '<a href="">'+$data.title+'</a>';
                break;
            case 'voice':
                $html = '<a href="">'+$data.source_url+'</a>';
                break;
            case 'article':
                $html = '<a href="'+$data.source_url+'" >' + $data.title + '</a>';
                break;
        }

        return $mediaPreviewItem({item:$html});
    }

    ResponsePicker.prototype.showForm = function ($data) {
        var $tab = this.getCurrentTab();

        $tab.find('form-container').slideDown();

        if (!$data) {
            return;
        };

        var $previewContainer = $tab.find('.preview-container');
        var $previewItem = this.getPreviewItem($data.type, $data);

        switch($type){
            case 'text':
                $currentTab.find('.wechat-editor-content').html($data.text);
                break;
            case 'url':
                $currentTab.find('[name=url]').val($data.url);
                break;
            case 'image':
            case 'video':
            case 'voice':
            case 'article':
            default:
                $tab.find('.media_id').val($data.media_id);
                break;
        }

        $previewContainer.html($previewItem);
    }

    ResponsePicker.prototype.save = function () {
        // body...
    }

    ResponsePicker.prototype.onChange = function () {
        // body...
    }

    return ResponsePicker;
});