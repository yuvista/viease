@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">粉丝管理</h2>
    </div>
    <div class="well row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-md-4"><span class="line-height-sm">全部粉丝</span></div>
                    <form action="" class="col-md-8 form-inline">
                        <div class="pull-right">
                            <div class="form-group">
                                <select name="sort_by" class="form-control input-sm">
                                    <option value="subscribe_at">关注时间</option>
                                    <option value="liveness">活跃度</option>
                                    <option value="last_speaking_at">最后发言时间</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm" placeholder="用户昵称">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-sm" type="button"><i class="ion-ios-search-strong"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="user-list clearfix ajax-loading">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">分组 <a href="javascript:;" data-toggle="modal" data-target="#new-group-modal" class="pull-right"><i class="ion-android-add icon-md"></i></a></div>
                <div class="list-group group-list ajax-loading">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="new-group-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">添加分组</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" class="form-horizontal">
            <div class="form-group row">
                <label for="group-name" class="col-md-3 control-label">分组名称：</label>
                <div class="col-md-6">
                    <input type="text" id="group-name" name="group_name" class="form-control">
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary">确认</button>
        </div>
      </div>
    </div>
</div>

<script id="group-template" type="text/plain">
    <a href="javascript:;" class="list-group-item">
      <span class="badge"><%= user_count %></span> <%= title %>
    </a>
</script>

<script id="user-template" type="text/plain">
    <div class="col-md-4 col-sm-6 user-item" >
        <div class="media">
            <div class="media-left">
                <a href="javascript:;">
                    <img src="<%= avatar %>" alt="" class="user-avatar user-avatar-small media-object img-responsive">
                </a>
            </div>
            <div class="media-body">
                <div class="user-nickname"><%= nickname %></div>
                <div class="text-muted"><%= location %></div>
            </div>
        </div>
    </div>
</script>

<script id="user-popover-template" type="text/plain">
    <table>
        <tr>
            <td colspan="2"><span class="nickname"><%= nickname %></span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="remark"><%= remark %></span> <a href="javascript:;"><i class="ion-ios-compose-outline icon-md"></i></a></td>
        </tr>

        <tr>
            <td class="popover-table-label">地区：</td>
            <td class="location"> <%= location %> </td>
        </tr>
        <tr>
            <td class="popover-table-label">分组：</td>
            <td>
                <select name="group" class="origin form-control" id="">
                    <option value="0">分组0</option>
                    <option value="1">分组1</option>
                    <option value="2">分组2</option>
                    <option value="3">分组3</option>
                    <option value="4">分组4</option>
                    <option value="5">分组5</option>
                    <option value="6">分组6</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="popover-table-label">签名：</td>
            <td class="signature"> <%= signature %></td>
        </tr>
    </table>
</script>
@stop

@section('js')
<script src="{{ asset('js/admin/repos/user.js') }}"></script>
<script>
    $(function(){
        var userTemplate    = _.template($('#user-template').html());
        var groupTemplate   = _.template($('#group-template').html());
        var popoverTemplate = _.template($('#user-popover-template').html());
        var userContainer   = $('.user-list');
        var groupContainer  = $('.group-list');

        // 加载用户列表
        function loadUsers($groupId, $sortBy, $page) {
            Repo.user.getUsers($groupId, $sortBy, $page, function(users){
                userContainer.html('');
                _.each(users, function(user){
                    var item = $(userTemplate(user));
                    item.data(user);
                    userContainer.append(item);
                });
            });
        }

        // 加载组列表
        function loadGroups($sortBy, $page) {
            Repo.user.getGroups($sortBy, $page, function(groups){
                groupContainer.html('');
                _.each(groups, function(group){
                    var item = $(groupTemplate(group));
                    item.data(group);
                    groupContainer.append(item);
                });
            });
        }

        loadUsers(); // 第一次加载全部用户
        loadGroups(); // 第一次加载全部组

        // 浮层
        $(document).on('mouseenter', '.user-item', function(){
            var data = $(this).data();
                data['html'] = true;

            if (!data.content) {
                var content = $(popoverTemplate(data));
                content.find('select').val(data.group_id).change()
                                        .find('[value="'+data.group_id+'"]')
                                        .attr('selected', true)
                                        .siblings().attr('selected', false);
                $(this).data('content', content);
            };

            $(this).popover($(this).data());
            $('.popover').popover('hide');
            $(this).popover('show');
        });

    });
</script>
@stop