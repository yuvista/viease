@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">菜单管理</h2>
    </div>
    <div class="well bs-component">
        <form>
            <input type="button" value="测试" id="test">
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
     $(function(){
        //测试使用哦
        $(document).on('click', '#test', function(){
            $.ajax({
                type: 'POST',
                url: '/admin/services/menu/store' ,
                data: {
                    menu: [
                        {
                            'type':'text',
                            'name':'个人中心',
                            'key':'http://www.baidu.com'
                        },
                        {
                            'type':null,
                            'name':'百度知道',
                            'key':null,
                            'sub_button':[
                                {
                                    'name':'验证码一',
                                    'type':'scancode_waitmsg',
                                    'key':null,
                                }
                            ]
                        },
                        {
                            'type':null,
                            'name':'菜单三',
                            'key':null,
                            'sub_button':[
                                {
                                    'name':'发送图文',
                                    'type':'material',
                                    'key':'1111111'
                                }
                            ]
                        }
                    ]
                },
                success: function(){

                }
            });
        });
     });
</script>
@endsection