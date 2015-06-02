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
  <link rel="stylesheet" href="{{ asset('/js/plugins/switchery/dist/switchery.min.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/plugins/sweetalert/lib/sweet-alert.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}" media="screen">
  @yield('css')
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('/plugin/html5shiv/dist/html5shiv.js') }}"></script>
  <script src="{{ asset('/plugin/respond/dest/respond.min.js') }}></script>
  <![endif]-->
</head>
<body>
  <header class="console-header">
    <div class="container">
      <div class="header-inner table-box">
        <div class="table-row">
          <div class="left table-cell">
            <div class="logo">
              <a href="{{ admin_url('/') }}"><img src="{{asset('img/logo.svg')}}" alt=""></a>
            </div>
          </div>
          <div class="right table-cell">
            <div class="top-nav">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>
              <ul class="nav navbar-nav navbar-main">
                @foreach($menus as $group)
                <li>
                  <a href="javascript:;" data-group="{{ $group['group'] }}">{{ $group['label'] }}</a>
                </li>
                @endforeach
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                          Admin
                          <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="#dropdown1">账号设置</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                              <a href="#dropdown2">注销</a>
                          </li>
                      </ul>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
    <div class="console-wrapper table-box">
      <section class="console-container table-row">
        <aside class="console-sidebar-wrapper table-cell">
        @include('admin.partials.sidebar')
        </aside>
        <section class="console-content-wrapper table-cell">
          @yield('content')
        </section>
      </section>
    </div>
    <div class="console-footer">
      <div class="clearfix text-center">
        <ul class="list-unstyled list-inline">
          <li>overtrue © 2015</li>
        </ul>
        <button class="pull-right hidden-print  back-to-top" onclick="window.scrollTo(0,0)"> <i class="ion-android-arrow-dropup"></i>
        </button>
      </div>
    </div>
  </div>
  <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/sweetalert/lib/sweet-alert.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/switchery/dist/switchery.min.js') }}"></script>
  <script src="{{ asset('/js/sweetalert.util.js') }}"></script>
  <script src="{{ asset('/js/admin/app.js') }}"></script>
  @yield('js')
</body>
</html>