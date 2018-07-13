  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">

          @if(Auth::user()->employee->profile_picture)
           <img src="{{ URL::asset('admin/uploads/profile_picture/'.Auth::user()->employee->profile_picture) }}" class="img-circle" alt="User Image">
          @else
           <img src="{{ URL::asset('admin/dist/img/user.png')}}" class="img-circle" alt="User Image">
          @endif
          
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="{{ route('user.profile.index') }}"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <!--<div class="input-group">-->
        <!--  <input type="text" name="q" class="form-control" placeholder="Search...">-->
        <!--  <span class="input-group-btn">-->
        <!--        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>-->
        <!--        </button>-->
        <!--      </span>-->
        <!--</div>-->
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGASI UTAMA</li>
        <li class="{{ Request::is('/') ? 'active' : '' }}">
          <a href="{{ url('/')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <!-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i> -->
            <!-- </span> -->
          </a>
          <!-- <ul class="treeview-menu">
            <li class="active"><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul> -->
        </li>

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li> -->
        @if (Auth::user()->level == 'Admin')
        <li class="treeview 
        {{ Request::is('admin/employee') ? 'active' : '' }}
        {{ Request::is('admin/position') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Kelola Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/employee') ? 'active' : '' }}"><a href="{{ url('/admin/employee')}}"><i class="fa fa-circle-o"></i> Karyawan</a></li>
            <li class="{{ Request::is('admin/position') ? 'active' : '' }}"><a href="{{ url('/admin/position')}}"><i class="fa fa-circle-o"></i> Posisi</a></li>
          <!--   <li><a href="{{ url('/admin/allowance')}}"><i class="fa fa-circle-o"></i> Tunjangan</a></li>
            <li><a href="{{ url('/admin/empallowance')}}"><i class="fa fa-circle-o"></i> Tunjangan Karyawan</a></li> -->
            <!-- <li><a href="{{ url('/admin/user')}}"><i class="fa fa-circle-o"></i> Pengguna</a></li> -->
          </ul>
        </li>
        <li class="treeview 
        {{ Request::is('admin/presence/data') ? 'active' : '' }} 
        {{ Request::is('admin/historypresence') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-clock-o"></i> <span>Kelola Presensi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/presencedata') ? 'active' : '' }}"><a href="{{ url('/admin/presencedata')}}"><i class="fa fa-circle-o"></i> Presensi Bulan Ini</a></li>
            <li class="{{ Request::is('admin/historypresence') ? 'active' : '' }}"><a href="{{ url('/admin/historypresence')}}"><i class="fa fa-circle-o"></i> Daftar Presensi</a></li>
          </ul>
        </li>
        <li class="treeview
        {{ Request::is('admin/salary') ? 'active' : '' }}
        {{ Request::is('admin/employeesalary') ? 'active' : '' }}
        {{ Request::is('admin/historysalary') ? 'active' : '' }}
        ">
          <a href="#">
            <i class="fa fa-dollar"></i> <span>Kelola Penggajian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/salary') ? 'active' : '' }}"><a href="{{ url('/admin/salary')}}"><i class="fa fa-circle-o"></i> Progres Gaji Bulan Ini</a></li>
            <li class="{{ Request::is('admin/employeesalary') ? 'active' : '' }}"><a href="{{ url('/admin/employeesalary')}}"><i class="fa fa-circle-o"></i> Penggajian Karyawan</a></li>
            <li class="{{ Request::is('admin/historysalary') ? 'active' : '' }}"><a href="{{ url('/admin/historysalary')}}"><i class="fa fa-circle-o"></i> Daftar Penggajian</a></li>
          </ul>
        </li>
        <li class="treeview
        {{ Request::is('admin/schedule') ? 'active' : '' }}
        {{ Request::is('admin/historyschedule') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-calendar-plus-o"></i> <span>Kelola Jadwal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/schedule') ? 'active' : '' }}"><a href="{{ url('/admin/schedule')}}"><i class="fa fa-circle-o"></i> Penjadwalan</a></li>
            <li class="{{ Request::is('admin/historyschedule') ? 'active' : '' }}"><a href="{{ url('/admin/historyschedule')}}"><i class="fa fa-circle-o"></i> Daftar Penjadwalan</a></li>
          </ul>
        </li>
        <li class="treeview
        {{ Request::is('admin/menu') ? 'active' : '' }}
        {{ Request::is('admin/transaction') ? 'active' : '' }}
        {{ Request::is('admin/historytransaction') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>Kelola Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/menu') ? 'active' : '' }}"><a href="{{ url('/admin/menu')}}"><i class="fa fa-circle-o"></i> Menu</a></li>
            <li class="{{ Request::is('admin/transaction') ? 'active' : '' }}"><a href="{{ url('/admin/transaction')}}"><i class="fa fa-circle-o"></i> Transaksi</a></li>
            <li class="{{ Request::is('admin/historytransaction') ? 'active' : '' }}"><a href="{{ url('/admin/historytransaction')}}"><i class="fa fa-circle-o"></i> Daftar Transaksi</a></li>
          </ul>
        </li>
      
        <li class="header">NAVIGASI LAIN</li>
        <li>
          <a href="{{ route('user.presence.index') }}">
            <i class="fa fa-laptop"></i>
            <span>Presensi</span>
          </a>
        </li>
    <!--     <li>
          <a href="{{ url('/admin/shop')}}">
            <i class="fa fa-laptop"></i>
            <span>Kasir</span>
          </a>
        </li> -->
        @elseif (Auth::user()->level == 'Karyawan')
        <li class="{{ Request::is('employee/presence') ? 'active' : '' }}">
          <a href="{{ url('/employee/presence')}}">
            <i class="fa fa-address-card-o"></i>
            <span>Daftar Presensi</span>
          </a>
        </li>
        <li class="{{ Request::is('employee/schedule') ? 'active' : '' }}">
          <a href="{{ url('/employee/schedule')}}">
            <i class="fa fa-calendar-check-o"></i>
            <span>Daftar Jadwal</span>
          </a>
        </li>
        <li class="header">NAVIGASI LAIN</li>
        <li>
          <a href="{{ url('/employee/shop')}}">
            <i class="fa fa-laptop"></i>
            <span>Kasir</span>
          </a>
        </li>
        @elseif (Auth::user()->level == 'Manajer')
        <li class="{{ Request::is('manager/employee') ? 'active' : '' }}">
          <a href="{{ url('/manager/employee')}}">
            <i class="fa fa-users"></i>
            <span>Daftar Karyawan</span>
          </a>
        </li>
        <li class="treeview
        {{ Request::is('manager/presence/data') ? 'active' : '' }}
        {{ Request::is('manager/historypresence') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-clock-o"></i> <span>Kelola Presensi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('manager/presence/data') ? 'active' : '' }}"><a href="{{ url('/manager/presence/data')}}"><i class="fa fa-circle-o"></i> Presensi Bulan Ini</a></li>
            <li class="{{ Request::is('manager/historypresence') ? 'active' : '' }}"><a href="{{ url('/manager/historypresence')}}"><i class="fa fa-circle-o"></i> Daftar Presensi</a></li>
          </ul>
        </li>
        <li class="treeview
        {{ Request::is('manager/salary') ? 'active' : '' }}
        {{ Request::is('manager/historysalary') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-dollar"></i> <span>Kelola Penggajian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('manager/salary') ? 'active' : '' }}"><a href="{{ url('/manager/salary')}}"><i class="fa fa-circle-o"></i> Penggajian Bulan Ini</a></li>
            <li class="{{ Request::is('manager/historysalary') ? 'active' : '' }}"><a href="{{ url('/manager/historysalary')}}"><i class="fa fa-circle-o"></i> Daftar Penggajian</a></li>
          </ul>
        </li>
        <li class="treeview
        {{ Request::is('manager/transaction') ? 'active' : '' }}
        {{ Request::is('manager/historytransaction') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>Kelola Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('manager/transaction') ? 'active' : '' }}"><a href="{{ url('/manager/transaction')}}"><i class="fa fa-circle-o"></i> Transaksi</a></li>
            <li class="{{ Request::is('manager/historytransaction') ? 'active' : '' }}"><a href="{{ url('/manager/historytransaction')}}"><i class="fa fa-circle-o"></i> Daftar Transaksi</a></li>
          </ul>
        </li>
          <li class="treeview
        {{ Request::is('manager/topsiskriteria') ? 'active' : '' }}
        {{ Request::is('manager/result') ? 'active' : '' }}
        {{ Request::is('manager/historytopsis') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-star"></i> <span>Kelola Peringkat Karyawan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('manager/topsiskriteria') ? 'active' : '' }}"><a href="{{ url('manager/topsiskriteria') }}"><i class="fa fa-circle-o"></i> Buat Peringkat Karyawan</a></li>
            <li class="{{ Request::is('manager/result') ? 'active' : '' }}"><a href="{{ url('manager/result') }}"><i class="fa fa-circle-o"></i> Hasil Peringkat Bulan Ini</a></li>
            <li class="{{ Request::is('manager/historytopsis') ? 'active' : '' }}"><a href="{{ url('/manager/historytopsis')}}"><i class="fa fa-circle-o"></i> Daftar Peringkat Karyawan</a></li>
          </ul>
        </li>
        @endif
       <!--  <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li> -->
  <!--       <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
