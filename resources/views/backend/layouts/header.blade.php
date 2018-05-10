<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CO</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Cafe</b> Omboy</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              @if(Auth::user()->employee->profile_picture)
                <img src="{{ URL::asset('admin/uploads/profile_picture/'.Auth::user()->employee->profile_picture) }}" class="user-image" alt="User Image">
              @else
                <img src="{{ URL::asset('admin/dist/img/user.png')}}" class="user-image" alt="User Image">
              @endif

              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              @if(Auth::user()->employee->profile_picture)
                <img src="{{ URL::asset('admin/uploads/profile_picture/'.Auth::user()->employee->profile_picture) }}" class="img-circle" alt="User Image">
              @else
                <img src="{{ URL::asset('admin/dist/img/user.png')}}" class="img-circle" alt="User Image">
              @endif
                <p>
                  {{ Auth::user()->name }} - <b>{{ Auth::user()->level }}</b>
                  <small>Karyawan sejak {{ date('d M Y', strtotime(Auth::user()->created_at)) }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('user.profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>