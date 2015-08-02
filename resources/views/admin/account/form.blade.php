@extends('admin.layout')

@section('content')
<div class="console-content">
<video src="http://203.205.148.147/vweixinp.tc.qq.com/1007_9735434267934c07a8801264240d13af.f10.mp4?vkey=D08904382A437504C73B61B708EB0401DC22EBEA4BBF954CE8177B9D7BF2A8EE4B0D510796673A30&sha=0&save=0" controls="true" poster="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAM1BMVEX///+/v7+8vLz19fXd3d3ExMTJycnS0tLx8fHBwcHh4eH8/Pzp6enm5ub5+fns7OzX19dCWVlCAAACnUlEQVR4nO3c23qrIBCGYcQNMW6S+7/aSmKyYh0QjyZd872HrQc8/yMDDLbOAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/GX1bZyu0+0yaw/ky81jaP1b1TW19oi+1TCGmNAn71vyEgzXdhvUK68qXLTH9m0mOarn6xUoXx/qkIzqEVc/aY/we4x9NqsYVxi0B/klmqOoYlodUzG6F2QVpyLLYmlWEWmVzMFVb30mTuVZLXVLe7S66hNZLWndtcerqjuT1ZLWTXvAiq6nXqxFa3e7Nfcns6p8oz1mNSdWwhezK6L0YtVdPkB/1R61EqFi+eWnVTYuq1VLWAqXsA5aEEYXRGmP5R+/yXUhfFAetg5p3+DX32UOjK3qoLVIG9JXWC5d6L3FLvPQ5sJaXrzEXPQWu6bisfAjLDfLhd7kAfF2FNbyiHiLYbH3IDZntmG5QSr0Fiu8eIj2v5+SCr3GaJWJB8NdWDFUf/jMf680LOcCYRWHNbaEVVazhKLVKwxW21gS1tDsexAWtw6XgrDEjZbFk/QsZLUNS97C2+wsZw/SLtkFtNnQknbn/8JKtx1MduGlw+ErrCF9l2Gxvi+BCPcVa1jyCfr5hNEbC2EePsJK9GZWRr+lETYPMaxU1+/5gMWNw8N+PfTukr84tLkWRkKJP/j6we6L5dy+OB1d6Fu8rVjVB9HsorTYf387+c2R1bv7Vf6vBX6/WIYnYSTeHqaysnhjuFEXf9Bms92wVVrkbRf3lzp9EOS92pkPvvaLUVXm69Vbc5RVZ3wd3MieCH3V2N5f7ST/lNX7YLQrkzFM3e+L+phUfycqUd08/lHBOyhfhZEJmDbfmtC1fdV34T7xTgEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgD/sB9/OEMCxfi8pAAAAAElFTkSuQmCC" onclick="this.play(false)"></video>
    <div class="page-header">
        <h2 id="nav">@if(isset($account)) 编辑公众号 @else 添加公众号 @endif</h2>
    </div>
    <div class="well bs-component">
        @form(['url' => isset($account)? admin_url('account/update/'.$account->id): admin_url('account/create'), 'method' => 'post', 'class' => 'form-horizontal'])
        @col_input('text','name',$errors,'*公众号名称',isset($account) ? $account->name : old('name'), ['placeholder' => '例如：微易'])
        @col_input('text','original_id',$errors,'*公众号原始Id',isset($account) ? $account->original_id : old('original_id'),['placeholder' => '请认真填写，错了不能修改。例如gh_gks84hksi90o'])
        @col_input('text','wechat_account',$errors,'*微信号',isset($account) ? $account->wechat_account : old('wechat_account') ,['placeholder' => '例如：viease'])
        @col_input('text','app_id',$errors,'AppID（公众号）',isset($account) ? $account->app_id : old('app_id'),['placeholder' => '用于自定义菜单等高级功能'])
        @col_input('text','app_secret',$errors,'AppSecret ',isset($account) ? $account->app_secret : old('app_secret'),['placeholder' => '用于自定义菜单等高级功能'])
        @col_select('account_type', [1 => '订阅号', 2 => '服务号'], $errors, '微信号类型 ', isset($account) ? $account->account_type : old('account_type'),['placeholder' => '认证服务号是指每年向微信官方交300元认证费的公众号'])
        @col_submit('提交')
        @endform
    </div>
</div>
@endsection