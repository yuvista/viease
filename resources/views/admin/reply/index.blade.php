@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">自动回复</h2>
    </div>
    <div class="well row">
    <a href="javascript:;" id="tester">保存测试</a>
    <a href="javascript:;" id="save">修改测试</a>
    <script type="text/javascript">
    $(function(){
        $('#tester').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/reply/save-event-reply',
              data: {
                    type:"follow",
                    reply_content:"xxxxxxxx",
                    reply_type:'text'
                },
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(function(){
        $('#save').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/reply/save-event-reply',
              data: {
                    type:"follow",
                    reply_content:"xxxxxxxx",
                    reply_type:'text'
                },
            });
        });
    });
    </script>

    </div>
</div>
@stop