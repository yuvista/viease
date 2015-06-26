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
                    <div class="menus no-menus resizeable">

                    </div>
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

<script type="text/plain" id="no-menus-content-template">
    <div class="blankslate spacious">
        <p>尚未配置菜单</p>
        <div><a href="javascript:;" class="add-menu-item">点此立即创建</a></div>
    </div>
</script>
<script type="text/plain" id="menu-item-template">
<div class="list-group-item menu-item"><%= menu.name %> <button type="button" class="btn btn-default btn-xs pull-right"><i class="ion-compose"></i></button></div>
</script>
<script type="text/plain" id="menu-item-form-template">
    <div class="list-group-item">
        <form action="" method="post" accept-charset="utf-8" class="menu-item-form">
            <div class="form-group">
                <input type="text" name="name" placeholder="" class="form-control">
            </div>
            <input type="hidden" name="id" value="<% if (typeof menu != 'undefined') { %><%= menu.id %><% } %>">
            <button type="submit" class="btn btn-xs btn-success">保存</button>
            <button type="button" class="btn btn-xs btn-danger cancel-do">取消</button>
        </form>
    </div>
</script>
@stop

@section('js')
<script src="{{ asset('js/admin/repos/menu.js') }}"></script>
<script>
$(function(){
    // 菜单列表
    var menusListContainer   = $('.menus');
    var emptyMenusTemplate   = _.template($('#no-menus-content-template').html());
    var menuItemFormTemplate = _.template($('#menu-item-form-template').html());
    var menuItemTemplate     = _.template($('#menu-item-template').html());
    var i = 0;

    // 监听变化
    menusListContainer.domchanged(function(){
        if ($(this).height() < 50) {
            $(this).html(emptyMenusTemplate()).addClass('no-menus');;
        };
    });

    // 显示菜单列表
    function listsMenu () {
        Repo.menu.getMenus(function($menus){
            // clean
            menusListContainer.html('').removeClass('no-menus');

            _.each($menus, function($menu){
                menusListContainer.append(menuItemTemplate( { menu: $menu } ));
            });
        });
    }

    listsMenu();

    // 创建
    $(document).on('click', '.add-menu-item', function(){
        if (menusListContainer.hasClass('no-menus')) {
            menusListContainer.html('').removeClass('no-menus');
        };

        var $form = menuItemFormTemplate();

        menusListContainer.append($form);

        menusListContainer.find('input').focus();
    });

    // 表单提交
    $(document).on('submit', '.menus form.menu-item-form:first', function(e){
        e.preventDefault();
        var $params = Util.parseForm($(this));

        if ($params.id) {
            Repo.menu.updateMenu($params.id, $params, listsMenu);
        } else {
            Repo.menu.createMenu($params, listsMenu);
        }
    });

    // 取消
    $(document).on('click', '.menus form .cancel-do', function(e){
        e.preventDefault();
        var $params = Util.parseForm($(this));

        if (!$params.id) {
            $(this).closest('form').remove();
        };
    });
});
</script>
@stop