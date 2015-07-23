@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">自动回复</h2>
    </div>
    <div class="well">
        <div class="panel panel-default">
            <div class="panel-heading">规则1</div>
            <div class="panel-body">
                <div class="keywords">关键词：股票</div>
                <div class="replys">回复：xxxx</div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">规则1</div>
            <div class="panel-body">
                <div class="keywords">关键词：股票</div>
                <div class="replys">回复：xxxx</div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">规则1</div>
            <div class="panel-body">
                <div class="keywords">关键词：股票</div>
                <div class="replys">回复：xxxx</div>
            </div>
        </div>

    <!--样例使用完后删除-->
    <a href="javascript:;" id="tester">保存测试</a>
    <a href="javascript:;" id="save">修改测试</a>
    <a href="javascript:;" id="add">增加一个自动回复</a>
     <a href="javascript:;" id="update">修改一个自动回复</a>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
    $(function(){
        $('#tester').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/reply/save-event-reply',
              data: {
                    type:"follow",
                    reply_content:"MEDIA_XXXXXXXXXXXXX",
                    reply_type:'material'
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
                    reply_content:"你好啊",
                    reply_type:'text'
                },
            });
        });
    });
    </script>

    <script type="text/javascript">
    $(function(){
        $('#add').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/reply/store',
              data: {
                    name:"粉丝22",
                    trigger_keywords:[
                        "大学1","你好2"
                    ],
                    trigger_type:"contain",
                    replies:[
                        {
                            'type':'text',
                            'content':'你好啊大家好才是真的好'
                        },
                        {
                            'type':'material',
                            'content':'MEDIA_123456789'
                        }
                    ],
                },
            });
        });
    });
    </script>

      <script type="text/javascript">
    $(function(){
        $('#update').click(function(){
            $.ajax({
              type: 'POST',
              url: '/admin/reply/update/15',
              data: {
                    name:"粉丝",
                    trigger_keywords:[
                       "大学","你好"
                    ],
                    trigger_type:"contain",
                    replies:[
                        {
                            'type':'text',
                            'content':'大家好才是真的好'
                        }
                    ],
                },
            });
        });
    });
    </script>
    <!--End 样例使用完删除-->
    </div>
</div>
@stop