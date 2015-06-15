@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">公众号列表</h2>
    </div>
    <div class="well bs-component">
        <table class="table table-wechat">
            <thead class="thead">
                <tr>
                    <td>公众号名称</td>
                    <td>微信号</td>
                    <td>类型</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody class="tbody">
                @if($accounts->count())
                    @foreach($accounts as $account)
                    <tr>
                        <td>{{$account->name}}</td>
                        <td>{{$account->wechat_account}}</td>
                        <td>@if($account->account_type ==1) 订阅号 @else 服务号 @endif</td>
                        <td>{{$account->created_at->format('Y-m-d H:i:s')}}</td>
                        <td>
                            <a href="{{ admin_url('account/change-account/'.$account->id)}}" class="btn btn-success btn-xs">管理</a> 
                            <a href="{{ admin_url('account/update/'.$account->id)}}" class="btn btn-default btn-xs">编辑</a> 
                            <a href="{{ admin_url('account/delete/'.$account->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('删除后无法恢复,确定要删除吗')">删除</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="5"> 
                        <span class="empty_tips">暂无公众号，点击<a href="{{ admin_url('account/create') }}" >添加公众号</a></span>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection