
  @foreach (Config::get('menu') as $m)
        @if (strpos($m->level, Auth::user()->level) !== false)
        <li class="nav-item">
            <a href="{{ route($m->route) }}" class="nav-link {{ Route::currentRouteName() == $m->route ? 'active':''}}">
                <i class="far fa-circle nav-icon"></i>
              <p>
                {{ $m->nama_menu }}
              </p>
            </a>
          </li>
        @endif
    @endforeach




