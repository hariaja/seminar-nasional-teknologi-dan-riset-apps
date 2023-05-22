<div class="content py-3">
  <!-- Toggle Main Navigation -->
  <div class="d-lg-none">
    <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
    <button type="button" class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
      {{ trans('Menu Navigation') }}
      <i class="fa fa-bars"></i>
    </button>
  </div>
  <!-- END Toggle Main Navigation -->

  <!-- Main Navigation -->
  <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
    <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
      <li class="nav-main-item">
        <a class="nav-main-link {{ Request::is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
          <i class="nav-main-link-icon si si-compass"></i>
          <span class="nav-main-link-name">{{ trans('page.overview.title') }}</span>
        </a>
      </li>

      @canany(['roles.index', 'users.index'])
        <li class="nav-main-heading">{{ trans('Management') }}</li>
        <li class="nav-main-item">
          <a class="nav-main-link {{ Request::is('settings*') ? 'active' : '' }} nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ Request::is('settings*') ? 'true' : 'false' }}" href="#">
            <i class="nav-main-link-icon fa fa-cog"></i>
            <span class="nav-main-link-name">{{ trans('Settings') }}</span>
          </a>
          <ul class="nav-main-submenu">
            @can('users.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('settings/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                  <span class="nav-main-link-name">{{ trans('Pengguna') }}</span>
                </a>
              </li>
            @endcan
            @can('roles.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('settings/roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                  <span class="nav-main-link-name">{{ trans('Role & Permission') }}</span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcan
      
    </ul>
  </div>
  <!-- END Main Navigation -->
</div>