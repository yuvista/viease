<nav id="sidebar-nav">
  @foreach($menus as $group)
  <ul class="list-nav list-nav-{{$group['group']}}" style="display:none">
    <li class="separator">
      <div>
        <span>overview</span>
      </div>
    </li>
    @foreach($group['collection'] as $menu)
    <li>
      <a href="javascript:;"> <i class="{{ $menu['icon'] }}"></i>{{$menu['label']}}</a>
      @if(!empty($menu['submenus']))
      <ul class="second-nav">
        @foreach($menu['submenus'] as $submenu)
         <li><a href="{{ URL::to('/admin/'.$menu['uri'].'/'.$submenu['uri']) }}"><span>{{$submenu['label']}}</span></a></li>
        @endforeach
      </ul>
      @endif
    </li>
    @endforeach
  </ul>
  @endforeach
</nav>