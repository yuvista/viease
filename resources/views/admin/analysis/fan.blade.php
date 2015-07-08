@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">粉丝 - 数据统计</h2>
    </div>
    <div class="well">
        <div id="main" style="height:400px;"></div>
    </div>
</div>
@stop

@section('js')
<script>
    require(['pages/anaylsis.fan']);
</script>
@stop