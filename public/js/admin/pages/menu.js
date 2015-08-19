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
        var $responseContainer = $('.response-content');

        // 监听变化
        $menusListContainer.ifEmpty(function(el){
            el.html($emptyMenusTemplate()).addClass('no-menus');
        });
        $responseContainer.ifEmpty(function(el){
            el.html('<div class="blankslate spacious">你可以从左边创建一个菜单并设置响应内容。</div>');
        });
// listsMenuFromDB();
        // 显示菜单列表
        function listsMenuFromDB () {
            MenuRepo.getMenus(function($menus){
                console.log($menus);
                // clean
                $menusListContainer.html('').removeClass('no-menus');

                $res = {};

                //TODO:
                // _.each($menus, function($menu){
                //     var $id = (new Date).getTime();

                //     $res[$id] = {
                //         id: $id,
                //         name: $menu['name'],
                //         type: $menu['type'],
                //     };
                // });
                return $res;
            });
        }

        function listMenus ($menus) {
            for ($id in $menus) {
                var $button = $menus[$id];
                var $target = $menusListContainer;

                if (!isNaN($button.parent) && $button.parent > 0) {
                    $target = $('#'+$button.parent).find('> .sub-buttons');
                }

                $target.removeClass('no-menus');

                $target.append($($menuItemTemplate({ menu: $button })).data($button));
            }
        }

        // 本地存储的
        var $cachedMenus = Menu.all();

        if ($cachedMenus) {
            listMenus($cachedMenus);
        } else {
            $menus = listsMenuFromDB();
            console.log($menus);
        }

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

        /**
         * 点击父级时显示
         *
         * @param {Menu} $menu
         */
        function showFirstLevelContent ($menu) {
            $blankslate = $('<div class="blankslate spacious"><a href="javascript:;" class="btn btn-success">添加子级</a></div>');
            $blankslate.find('.btn').on('click', function(){
                $('.menu-item[id='+$menu.id+'] .actions .add-sub').trigger('click');
            });
            $('.response-content').html($blankslate);
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
            if ($item.data('parentId')) {return;};

            if ($subButtons.find('.menu-item').length >= 5) {
                return error('最多只有 5 个二级菜单');
            };

            createMenuItemForm($subButtons, $item.attr('id'));
        });

        // 删除菜单
        $(document).on('click', '.actions .trash', function(event){
            event.stopPropagation();
            var $item = $(this).closest('.menu-item');

            $item.slideUp(300, function(){
                Menu.delete($(this).attr('id'));
                $(this).remove();

                // 父级下面如果没有了更新父级属性
                if ($item.data('parentId')) {
                    var $parent = $('[id='+$item.data('parentId')+']');
                    if (!$parent.find('.sub-buttons .menu-item').length) {
                        Menu.update($item.data('parentId'), {hasChild:false});
                    };
                };

                $responseContainer.html('');
            })
        });

        // 编辑菜单
        $(document).on('click', '.menu-item', function(event){
            event.stopPropagation();
            $('.menu-item.current').removeClass('current');
            $(this).addClass('current');
            var $menu = Menu.get($(this).attr('id'));

            if ($menu['hasChild']) {
                return showFirstLevelContent($menu);
            };

            showResponseContent($menu);
        });

        // 编辑菜单名称
        $(document).on('click', '.actions .edit', function(event){
            event.stopPropagation();
            var $item = $(this).closest('.menu-item').hide();

            var $id   = $item.attr('id');
            var $name = $item.find('.menu-item-name:first').text();

            $item.after($menuItemFormTemplate($item.data()));
        });

        // 创建菜单按钮表单提交
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

                if ($params['parent']) {
                    Menu.update($params['parent'], {hasChild:true});
                }

                $formItem.replaceWith($item);
                Menu.put($params['id'], $params);
            }
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

        // 提交菜单
        $(document).on('click', '.submit-menu', function(){
            submitMenu();
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
            var $currentTab = getCurrentTab();

            switch($type){
                case 'text':
                    $currentTab.find('.wechat-editor-content').html($data.previewContent);
                    break;
                case 'url':
                    $currentTab.find('[name=url]').val($data.url);
                    break;
                case 'image':
                    $currentTab.find('.preview-content').html($data.previewContent);
                    $currentTab.find('[name=image_media_id]').val($data.media_id);
                    break;
                case 'video':
                    $currentTab.find('.preview-content').html($data.previewContent);
                    $currentTab.find('[name=video_media_id]').val($data.media_id);
                    break;
                case 'voice':
                    $currentTab.find('.preview-content').html($data.previewContent);
                    $currentTab.find('[name=voice_media_id]').val($data.media_id);
                    break;
                case 'article':
                    $currentTab.find('.preview-content').html($data.previewContent);
                    $currentTab.find('[name=article_media_id]').val($data.media_id);
                    break;
                default:
                    break;
            }
        }

        // 当前面板的结果容器
        function getCurrentResultContainer () {
            return $('.tab-pane.active .result-container-wrapper');
        }

        // 当前激活的面板
        function getCurrentTab () {
            return $('.tab-pane.active');
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

        // 结果与表单切换
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

        // 添加事件监听到表单
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
                    case 'image':
                        if (!$params.image_media_id.length) {
                            return error('请选择图片！');
                        };
                        $content = $('.tab-pane.active .preview-content').html();
                        $data = {image: $params.image_media_id, previewContent: $content};
                        break;
                    case 'video':
                        if (!$params.video_media_id.length) {
                            return error('请选择视频！');
                        };
                        $content = $('.tab-pane.active .preview-content').html();
                        $data = {video: $params.video_media_id, previewContent: $content};
                        break;
                    case 'voice':
                        if (!$params.voice_media_id.length) {
                            return error('请选择声音！');
                        };
                        $content = $('.tab-pane.active .preview-content').html();
                        $data = {voice: $params.voice_media_id, previewContent: $content};
                        break;
                    case 'article':
                        if (!$params.article_media_id.length) {
                            return error('请选择图文！');
                        };
                        $content = $('.tab-pane.active .preview-content').html();
                        $data = {article: $params.article_media_id, previewContent: $content};
                        break;
                    default:
                        return;
                        break;
                }

                saveMenu($content, {content:$data, type: $params.type});
                toggleResultAndForm('result');
            });
        }

        // 提交设置好的菜单到后端
        function submitMenu () {
            var $menus = Menu.all();
            var $data = {};

            for($id in $menus){
                var $item = {
                    name: $menus[$id].name,
                    type: $menus[$id]['type'] ? ($menus[$id]['type'] == 'url' ? 'view' : $menus[$id]['type']) : null,
                };
                $item['value'] = $menus[$id]['content'][$menus[$id]['type']];

                if (!$menus[$id].hasChild && !$item['value']) {
                    return error('请设置菜单 "'+$item.name+'" 的响应内容！');
                };

                if ($menus[$id].parent) {

                    $data[$menus[$id].parent]['sub_button'] = $data[$menus[$id].parent]['sub_button'] || [];
                    $data[$menus[$id].parent]['sub_button'].push($item);
                } else {
                    $data[$id] = $item;
                }
            }

            MenuRepo.submitMenu($data, function(){
                Menu.clean();
                success('保存成功！');
                setTimeout(function(){
                    window.location.reload();
                }, 1500);
            });
        }
    });
});