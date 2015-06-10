
// 用户相关的js
$(document).on('mouseenter', '.user-item', function(){
    var data = $(this).data();
        data['html'] = true;

    $('#user-popover-template select').val(data.groupId).change().find('[value="'+data.groupId+'"]').attr('selected', true).siblings().attr('selected', false);

    if (!data.content) {
        var groupSelector = $(content).find('select');
        var content = $('#user-popover-template').html();

        for(i in data){
            content = content.replace((new RegExp(i.toUpperCase(), 'g')), data[i]);
        }

        $(this).data('content', content);
    };

    $(this).popover($(this).data());
    $('.popover').popover('hide');
    $(this).popover('show');
});

// 用户仓库
var UserRepo = {
    // 获取用户列表
    getUsers: function ($groupId, $sortBy, $page, $callback) {
        var $request = {
            group_id: $groupId || null,
            sort_by: $sortBy || null,
            page: $page || 1,
        };

        Util.request('GET', 'user/lists', $request, $callback);
    },

    // 修改用户备注
    setRemark: function ($userId, $remark, $callback) {
        var $request = {
            remark: $remark
        };

        Util.request('POST', 'user/remark/' + $userId, $request, $callback);
    },

    // 移动用户（一个或者多个）到分组
    updateUserGroup: function ($userId, $groupId, $callback) {
        var $request = {
            user_id: $userId,
            group_id: $groupId
        };

        Util.request('POST', 'user/set-group', $request, $callback);
    },

    // 获取分组列表
    getGroups: function ($sortBy, $page, $callback) {
        var $request = {
            sort_by: $sortBy || null,
            page: $page || 1,
        };

        Util.request('GET', 'user-gourp/lists', $request, $callback);
    },

    // 创建分组
    createGroups: function ($name, $callback) {
        var $request = {
            name: $name
        };

        Util.request('POST', 'user-group/store', $request, $callback);
    },

    // 修改分组
    updateGroup: function ($groupId, $name, $callback) {
        var $request = {
            name: $name
        };

        Util.request('POST', 'user-group/update/' + $groupId, $request, $callback);
    },
};

