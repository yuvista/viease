/**
 * 菜单管理页 js
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
define(['jquery', 'repos/menu-store', 'repos/menu', 'util', 'admin/common'], function ($, Menu, MenuRepo, Util) {
    $(function(){
        // 菜单列表
        var $menusListContainer   = $('.menus');
        var $emptyMenusTemplate   = _.template($('#no-menus-content-template').html());
        var $menuItemFormTemplate = _.template($('#menu-item-form-template').html());
        var $menuItemTemplate     = _.template($('#menu-item-template').html());

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

                if ($button.parent) {
                    $target = $('#'+$button.parent).find('.sub-buttons').removeClass('no-menus');
                }

                $target.append($($menuItemTemplate({ menu: $button })).data($button));
            }
        } else {
            listsMenuFromDB();
        }

        /**
         * 创建表单
         *
         * @param {Object} $target
         */
        function createMenuItemForm ($target, $parentId) {
            if ($target.hasClass('no-menus')) {
                $target.html('').removeClass('no-menus');
            };

            var $form = $menuItemFormTemplate({ parent: ($parentId || 0) });

            $target.append($form);

            $target.find('input').focus();
        }

        // 创建一级
        $(document).on('click', '.add-menu-item', function(){
            if ($menusListContainer.find('> .menu-item').length >= 3) {
                return error('最多只有 3 个一级菜单');
            };
            createMenuItemForm($menusListContainer);
        });

        // 创建二级
        $(document).on('click', '.actions .add-sub', function(){
            var $item = $(this).closest('.menu-item');
            var $subButtons = $item.find('.sub-buttons:first');

            if ($subButtons.find('.menu-item').length >= 5) {
                return error('最多只有 5 个二级菜单');
            };

            createMenuItemForm($subButtons, $item.attr('id'));
        });

        // 删除菜单
        $(document).on('click', '.actions .trash', function(){
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
        });

        // 编辑菜单名称
        $(document).on('click', '.actions .edit', function(){
            var $item = $(this).closest('.menu-item').hide();

            var $id   = $item.attr('id');
            var $name = $item.find('.menu-item-name:first').text();

            $item.after($menuItemFormTemplate({ name: $name, id: $id }));
        });

        // 表单提交
        $(document).on('submit', '.menus form.menu-item-form:first', function(e){
            e.preventDefault();
            var $params = Util.parseForm($(this));
            var $formItem = $(this).closest('.list-group-item');

            if ($params.name.replace(' ', '').length < 1) {
                error('名称不能为空！');
            };

            // 更新
            if ($params.id) {
                $('#'+$params.id).data($params).show()
                .find('.menu-item-heading .menu-item-name:first').text($params.name);
                $formItem.remove();
            } else {
                // 新建
                $params.id = (new Date).getTime();
                var $item   = $($menuItemTemplate({ menu: $params})).data($params);
                $formItem.replaceWith($item);
            }


            Menu.put($params['id'], $params);
        });

        // 取消
        $(document).on('click', '.menus form .cancel-do', function(event){
            event.preventDefault();
            var $form = $(this).closest('form.menu-item-form');
            var $params = Util.parseForm($form);

            if ($params.id) {
                $('#'+$params.id).show();
            }

            $(this).closest('form').parent().remove();
        });
    });
});