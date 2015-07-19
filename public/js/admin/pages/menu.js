/**
 * 菜单管理页 js
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
define(['jquery', 'repos/menu', 'util', 'admin/common'], function ($, Menu, Util) {
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
        function listsMenu () {
            Menu.getMenus(function($menus){
                // clean
                $menusListContainer.html('').removeClass('no-menus');

                _.each($menus, function($menu){
                    $menusListContainer.append($menuItemTemplate( { menu: $menu } ));
                });
            });
        }

        listsMenu();

        // 创建
        $(document).on('click', '.add-menu-item', function(){
            if ($menusListContainer.hasClass('no-menus')) {
                $menusListContainer.html('').removeClass('no-menus');
            };

            var $form = $menuItemFormTemplate();

            $menusListContainer.append($form);

            $menusListContainer.find('input').focus();
        });

        // 表单提交
        $(document).on('submit', '.menus form.menu-item-form:first', function(e){
            e.preventDefault();
            var $params = Util.parseForm($(this));

            if ($params.id) {
                Menu.updateMenu($params.id, $params, listsMenu);
            } else {
                Menu.createMenu($params, listsMenu);
            }
        });

        // 取消
        $(document).on('click', '.menus form .cancel-do', function(e){
            e.preventDefault();
            var $params = Util.parseForm($(this));

            if (!$params.id) {
                $(this).closest('form').parent().remove();
            };
        });
    });
});