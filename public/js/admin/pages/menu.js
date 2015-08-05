/**
 * 菜单管理页 js
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
define(['jquery', 'repos/menu-store', 'repos/menu', 'WeChatEditor', 'util', 'admin/media-picker', 'admin/common'], function ($, Menu, MenuRepo, WeChatEditor, Util, MediaPicker) {
    $(function(){
        // 菜单列表
        var $menusListContainer     = $('.menus');
        var $emptyMenusTemplate     = _.template($('#no-menus-content-template').html());
        var $menuItemFormTemplate   = _.template($('#menu-item-form-template').html());
        var $menuItemTemplate       = _.template($('#menu-item-template').html());
        var $responsePickerTemplate = _.template($('#response-content-picker').html());

        // 监听变化
        $menusListContainer.ifEmpty(function(el){
            el.html($emptyMenusTemplate()).addClass('no-menus');;
        });

        // 显示菜单列表
        function listsMenuFromDB () {
            MenuRepo.getMenus(function($menus){
                // clean
                $menusListContainer.html('').removeClass('no-menus');

                _.each($menus, function($menu){
                    $menusListContainer.append($menuItemTemplate({ menu: $menu }));
                });
            });
        }

        // 本地存储的
        var $cachedMenus = Menu.all();


        if (!$cachedMenus.length) {

            for ($id in $cachedMenus) {
                var $button = $cachedMenus[$id];
                var $target = $menusListContainer;

                if (!isNaN($button.parent) && $button.parent > 0) {
                    $target = $('#'+$button.parent).find('> .sub-buttons');
                }

                $target.removeClass('no-menus');

                $target.append($($menuItemTemplate({ menu: $button })).data($button));
            }
        } else {
            listsMenuFromDB();
        }

        new MediaPicker('.image-picker', {type: 'image'});
        new MediaPicker('.video-picker', {type: 'video'});
        new MediaPicker('.voice-picker', {type: 'voice'});
        new MediaPicker('.article-picker', {type: 'article'});

        /**
         * 创建表单
         *
         * @param {Object} $target
         */
        function createMenuItemForm($target, $parentId) {
            if ($target.hasClass('no-menus')) {
                $target.html('').removeClass('no-menus');
            };

            var $form = $menuItemFormTemplate({ parent: ($parentId || 0) });

            $target.append($form);

            $target.find('input').focus();
        }

        // 创建一级
        $(document).on('click', '.add-menu-item', function(event){
            event.stopPropagation();
            if ($menusListContainer.find('> .menu-item').length >= 3) {
                return error('最多只有 3 个一级菜单');
            };
            createMenuItemForm($menusListContainer);
        });

        // 创建二级
        $(document).on('click', '.actions .add-sub', function(event){
            event.stopPropagation();
            var $item = $(this).closest('.menu-item');
            var $subButtons = $item.find('.sub-buttons:first');

            if ($subButtons.find('.menu-item').length >= 5) {
                return error('最多只有 5 个二级菜单');
            };

            createMenuItemForm($subButtons, $item.attr('id'));
        });

        // 删除菜单
        $(document).on('click', '.actions .trash', function(event){
            event.stopPropagation();
            $(this).closest('.menu-item').slideUp(300, function(){
                Menu.delete($(this).attr('id'));
                $(this).remove();
            })
        });

        // 编辑菜单
        $(document).on('click', '.menu-item', function(event){
            event.stopPropagation();
            $('.menu-item.current').removeClass('current');
            $(this).addClass('current');
            showResponseContent(Menu.get($(this).attr('id')));
        });

        // 编辑菜单名称
        $(document).on('click', '.actions .edit', function(event){
            event.stopPropagation();
            var $item = $(this).closest('.menu-item').hide();

            var $id   = $item.attr('id');
            var $name = $item.find('.menu-item-name:first').text();

            $item.after($menuItemFormTemplate($item.data()));
        });

        // 表单提交
        $(document).on('submit', '.menus form.menu-item-form:first', function(event){
            event.preventDefault();
            event.stopPropagation();
            var $params = Util.parseForm($(this));
            var $formItem = $(this).closest('.list-group-item');

            if ($params.name.replace(' ', '').length < 1) {
                error('名称不能为空！');
            };

            $params['parent'] = parseInt($params['parent']) || 0;

            // 更新
            if ($params.id) {
                $('#'+$params.id).data($params).show()
                .find('.menu-item-heading .menu-item-name:first').text($params.name);
                $formItem.remove();
                Menu.update($params.id, $params);
            } else {
                // 新建
                $params.id = (new Date).getTime();
                var $item   = $($menuItemTemplate({ menu: $params})).data($params);
                $formItem.replaceWith($item);
            }


            Menu.put($params['id'], $params);
        });

        // 防止冒泡
        $(document).on('click', '.menus form', function (event) {
            event.stopPropagation();
        });

        // 取消
        $(document).on('click', '.menus form .cancel-do', function(event){
            event.preventDefault();
            event.stopPropagation();
            var $form = $(this).closest('form.menu-item-form');
            var $params = Util.parseForm($form);

            if ($params.id) {
                $('#'+$params.id).show();
            }

            $(this).closest('form').parent().remove();
        });

        // 显示一个按钮的内容
        function showResponseContent ($menu) {
            $('.response-content').html($responsePickerTemplate());
            $('.response-content ul.nav-tabs a').tab();
            $('.message-editor');
            new WeChatEditor($('.message-editor'), {textarea: 'text'});

            var $form = $('#response-content-form');
            var $resultContainer = getCurrentResultContainer();

            $type = $menu.type || 'text';

            $('.response-content ul.nav-tabs a').on('shown.bs.tab', function(){
                $form.find('[name=type]').val(getCurrentType());
                if (!getCurrentResultContainer().is(':visible')) {
                    $('#response-content-form .submit-btns').show();
                } else {
                    $('#response-content-form .submit-btns').hide();
                }
            });

            $('.response-content ul.nav-tabs a[data-type='+$type+']').trigger('click');

            dataToForm($menu['content'] || {}, $type);

            if (typeof $menu['content']['previewContent'] == undefined) {
                $menu['content']['previewContent'] = '';
            }

            toResultContainer($menu['content']['previewContent'], $menu['content']);
            if ($menu['content']['previewContent']) {
                toggleResultAndForm('result');
            };


            addFormListener($form);
        }

        // 从按钮显示表单
        function dataToForm ($data, $type) {
            var $form = $('#response-content-form');
            var $resultContainer = getCurrentResultContainer();

            switch($type){
                case 'text':
                    $form.find('.wechat-editor-content').html($data.previewContent);
                    break;
                case 'url':
                    $form.find('[name=url]').val($data.url);
                    break;
                default:
                    break;
            }
        }

        // 当前面板的结果容器
        function getCurrentResultContainer () {
            return $('.tab-pane.active .result-container-wrapper');
        }

        // 当前点击的类型
        function getCurrentType () {
            return $('ul.nav-tabs .active a').data('type');
        }

        function toResultContainer ($content, $data) {
            var $resultContainer = getCurrentResultContainer();
            var $contentArea = $resultContainer.find('.result-container');

            $contentArea.html($content).data($data);
        }

        // 表单 -> 结果
        function saveMenu ($content, $data) {
            toResultContainer($content, $data);
            var $menuId = $('.menu-item.current').data('id');
            Menu.update($menuId, {});
            Menu.update($menuId, $data);
            toggleResultAndForm('form');
        }

        function toggleResultAndForm ($type) {
            var $resultContainer = getCurrentResultContainer();

            if ($type == 'result') {
                $('.tab-pane.active .form-area').hide();
                $('#response-content-form .submit-btns').hide();
                $resultContainer.show();
            } else {
                $('.tab-pane.active .form-area').show();
                $('#response-content-form .submit-btns').show();
                $resultContainer.hide();
            }
        }

        function addFormListener ($form) {
            var $resultContainer = getCurrentResultContainer();
            var $contentArea = $resultContainer.find('.result-container');
            var $editButton = $resultContainer.find('.edit-btn');

            $editButton.on('click', function(event){
                event.preventDefault();
                var $data = $contentArea.data();
                dataToForm($data);
                toggleResultAndForm('form');
            });

            $form.on('submit', function(event){
                event.preventDefault();

                var $params = Util.parseForm($form);

                switch($params.type){
                    case 'text':
                        if (!$params.text.length) {
                            return error('请填写文字内容！');
                        };
                        $content = $(this).find('.wechat-editor-content').html();
                        $data = {text: $params.text, previewContent: $content};
                        break;
                    case 'url':
                        if (!$params.url.length || $params.url.indexOf('http://') !== 0) {
                            return error('请正确填写网址！');
                        };
                        $content = $params.url;
                        $data = {url: $params.url, previewContent: $content};
                        break;
                    default:
                        break;
                }

                saveMenu($content, {content:$data, type: $params.type});
                toggleResultAndForm('result');
            });
        }
    });
});