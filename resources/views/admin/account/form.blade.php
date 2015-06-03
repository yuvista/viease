@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">添加公众号</h2>
    </div>
    <div class="well bs-component">
        @form(['url' => admin_url('account/create'), 'method' => 'post', 'class' => 'form-horizontal'])
        @col_input('text','name',$errors,'*公众号名称：','')
        @col_input('text','original_id',$errors,'*公众号原始Id：','',['placeholder' => '请认真填写，错了不能修改。例如：gh_overtrue123'])
        @col_input('text','wechat_account',$errors,'*微信号：','',['placeholder' => '例如：overtrue123'])
        @col_input('text','app_id',$errors,'AppID（公众号）：','',['placeholder' => '用于自定义菜单等高级功能'])
        @col_input('text','app_secret',$errors,'AppSecret ：','',['placeholder' => '用于自定义菜单等高级功能'])
        @col_input('text','account_type',$errors,'微信号类型 ：','',['placeholder' => '认证服务号是指每年向微信官方交300元认证费的公众号'])
        @col_submit('提交')
        @endform
    </div>
</div>
@endsection