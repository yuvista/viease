(function(){

    var Repo = Repo || {};

    // 粉丝仓库
    Repo.fan = {
        // 获取粉丝列表
        getFans: function ($groupId, $sortBy, $page, $callback) {
            var $request = {
                group_id: $groupId || null,
                sort_by: $sortBy || null,
                page: $page || 1,
            };

            Util.request('GET', 'fan/lists', $request, $callback);
        },

        // 修改粉丝备注
        setRemark: function ($fanId, $remark, $callback) {
            var $request = {
                remark: $remark
            };

            Util.request('POST', 'fan/remark/' + $fanId, $request, $callback);
        },

        // 移动粉丝（一个或者多个）到分组
        updateFanGroup: function ($fanId, $groupId, $callback) {
            var $request = {
                fan_id: $fanId,
                group_id: $groupId
            };

            Util.request('POST', 'fan/set-group', $request, $callback);
        },

        // 获取分组列表
        getGroups: function ($sortBy, $page, $callback) {
            var $request = {
                sort_by: $sortBy || null,
                page: $page || 1,
            };

            Util.request('GET', 'fan-group/lists', $request, $callback);
        },

        // 创建分组
        createGroup: function ($title, $callback) {
            var $request = {
                title: $title
            };

            Util.request('POST', 'fan-group/store', $request, $callback);
        },

        // 修改分组
        updateGroup: function ($groupId, $title, $callback) {
            var $request = {
                title: $title
            };

            Util.request('POST', 'fan-group/update/' + $groupId, $request, $callback);
        },
    };

    return window.Repo = Repo;

})();