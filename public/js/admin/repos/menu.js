(function(){

    var Repo = Repo || {};

    // 菜单仓库
    Repo.menu = {
        // 获取菜单列表
        getMenus: function ($callback) {
            Util.request('GET', 'menu/lists', {}, $callback);
        },

        // 创建菜单
        createMenu: function ($request, $callback) {
            Util.request('POST', 'menu/store', $request, $callback);
        },

        // 更新菜单
        updateMenu: function ($menuId, $request, $callback) {
            Util.request('POST', 'menu/update/' + $menuId, $request, $callback);
        },

        // 删除菜单
        deleteMenu: function ($menuId, $callback) {
            Util.request('POST', 'menu/delete/' + $menuId, $callback);
        },
    };

    return window.Repo = Repo;

})();