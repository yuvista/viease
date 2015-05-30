<!DOCTYPE html>
<!--[if lte IE 6 ]>
<html class="ie ie6 lte-ie7 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7 lte-ie7 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 9 ]>
<html class="ie ie9" lang="zh-CN">
<![endif]-->
<!--[if (gt IE 9)|!(IE)]>
<!-->
<html lang="zh-CN">
  <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>后台管理</title>
  <meta name="keywords" content="overtrue,bootstrap, bootstrap theme" />
  <meta name="description" content="a bootstrap theme made by overtrue." />
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/ionicons.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}" media="screen">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('/plugin/html5shiv/dist/html5shiv.js') }}"></script>
  <script src="{{ asset('/plugin/respond/dest/respond.min.js') }}></script>
  <![endif]-->
</head>
<body>
  <header class="console-header table-box">
    <div class="left table-cell">
      <div class="logo"> <i class="ion-load-b"></i>
        小牛发大财
      </div>
    </div>
    <div class="right table-cell">
      <div class="top-nav">
        <div class="navbar">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div>
            <ul class="nav navbar-nav">
              @foreach($menus as $group)
              <li>
                <a href="javascript:;" data-module="{{$group['group']}}">{{$group['label']}}</a>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="console-wrapper">
    <section class="console-container">
      <aside class="console-sidebar-wrapper">
      @include('admin.partials.menu');
      </aside>
      <section class="console-content-wrapper">
        @yield('content')
        <div class="console-content-footer">
          <div class="clearfix">
            <ul class="list-unstyled list-inline pull-left">
              <li>overtrue © 2015</li>
            </ul>
            <button class="pull-right btn btn-default btn-sm hidden-print" back-to-top="" style="padding: 1px 10px;"> <i class="fa fa-angle-up"></i>
            </button>
          </div>
        </div>
      </section>
    </section>
  </div>
  <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/admin/app.js') }}"></script>
</body>
</html>