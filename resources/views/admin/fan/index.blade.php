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
                                    <option value="subscribed_at">关注时间</option>
                                    <option value="liveness">活跃度</option>
                                    <option value="last_online_at">最后发言时间</option>
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
                <div class="fans-list clearfix ajax-loading">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">分组 <a href="#new-group-modal" data-toggle="modal" data-target="#new-group-modal" class="pull-right"><i class="ion-android-add icon-md"></i></a></div>
                <div class="list-group group-list ajax-loading">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="new-group-modal">
    <form id="new-group" action="" method="post" class="form-horizontal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">添加分组</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="group-name" class="col-md-3 control-label">分组名称：</label>
                    <div class="col-md-6">
                        <input type="text" id="group-name" name="group_name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
              <button type="submit" class="btn btn-primary submit-group">确认</button>
            </div>
          </div>
        </div>
    </form>
</div>

<script id="group-template" type="text/plain">
    <% _.each(groups, function(group) { %>
    <a href="javascript:;" data-id="<%= group.id %>" class="list-group-item">
      <span class="badge"><%= group.fan_count %></span> <%= group.title %>
    </a>
    <% }); %>
</script>

<script id="fan-template" type="text/plain">
    <% _.each(fans, function(fan) { %>
    <div class="col-md-4 col-sm-6 fan-item" data-nickname="<%= fan.nickname %>" data-location="<%= fan.location %>" data-remark="<%= fan.remark %>" data-group-id="<%= fan.group_id %>" data-signature="<%= fan.signature %>">
        <div class="media">
            <div class="media-left">
                <a href="javascript:;">
                    <img src="<%= fan.avatar %>" alt="" class="fan-avatar fan-avatar-small media-object img-responsive">
                </a>
            </div>
            <div class="media-body">
                <div class="fan-nickname"><%= fan.nickname %></div>
                <div class="text-muted"><%= fan.location %></div>
            </div>
        </div>
    </div>
    <% }); %>
</script>

<script id="fan-popover-template" type="text/plain">
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
<script src="{{ asset('js/admin/repos/fan.js') }}"></script>
<script>
    $(function(){
        var fanTemplate    = _.template($('#fan-template').html());
        var groupTemplate   = _.template($('#group-template').html());
        var popoverTemplate = _.template($('#fan-popover-template').html());
        var fanContainer   = $('.fans-list');
        var groupContainer  = $('.group-list');
        var groupId = 0;
        var page = 1;
        var sortBy = $('[name="sort_by"]').val();

        // 加载用户列表
        function loadFans($groupId, $sortBy, $page) {
            $sortBy = $sortBy || sortBy;
            $page = $page || page;
            // 覆盖全局变量
            page = $page;
            sortBy = $sortBy;

            Repo.fan.getFans($groupId, $sortBy, $page, function($fans){
                if ($fans['current_page']) {
                    $fans = $fans.data;
                };
                fanContainer.html(fanTemplate({fans:$fans}));
            });
        }

        // 加载组列表
        function loadGroups($sortBy, $page) {
            Repo.fan.getGroups($sortBy, $page, function($groups){
                if ($groups['current_page']) {
                    $groups = $groups.data;
                };

                // 加入 “全部分组”
                var totalfans = _.reduce($groups, function(sum, group){return sum + group.fan_count;}, 0);

                $groups.unshift({id:0, title: "全部用户", fan_count:totalfans});

                groupContainer.html(groupTemplate({groups:$groups}));
            });
        }

        loadFans(); // 第一次加载全部用户
        loadGroups(); // 第一次加载全部组

        // 修改排序方式
        $(document).on('change', '[name="sort_by"]', function(){
            loadFans(groupId, $(this).val(), page);
        });

        // 分组切换
        $(document).on('click', '.group-list > a', function(){
            loadFans($(this).data('id'), sortBy);
            $(this).addClass('active').siblings('a').removeClass('active');
        });

        // 浮层
        $(document).on('mouseenter', '.fan-item', function(){
            var $data = $(this).data();
                $data['html'] = true;

            if (!$data['content']) {
                var content = $(popoverTemplate($data));
                content.find('select').val($data.group_id).change()
                                        .find('[value="'+$data.group_id+'"]')
                                        .attr('selected', true)
                                        .siblings().attr('selected', false);
                $(this).data('content', content);
            };

            $(this).popover($(this).data());
            $('.popover').popover('hide');
            $(this).popover('show');
        });

        // 新建分组
        $(document).on('submit', '#new-group', function(){
            var $params = Util.parseForm($('#new-group'));

            var $validator = Validator.make($params, {group_name:"required|min:1"}, {group_name:"名称"});
            if ($validator.fails()) {
                Util.formError($('#new-group'), $validator.messages());
                return false;
            };

            Repo.fan.createGroup($params.group_name, function($group){
                groupContainer.append(groupTemplate({groups: [$group]}));
                success('分组创建成功！');
                $('#new-group-modal').modal('hide').find('form').get(0).reset();
            }, function(err){
                if (err.status == 422) {
                    return Util.formError($('#new-group'), err.responseJSON);
                };
            });

            return false;
        });

    });
</script>
@stop