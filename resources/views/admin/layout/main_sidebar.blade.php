<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
      <span class="brand-text font-weight-light text-center">نظام AMBER</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>  --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="{{route('dash')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                لوحة التحكم

              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{route('add-provider1')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                أضافة مزود
                <span class="right badge badge-danger">جديدة</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{route('data-provider')}}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                المزودين
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            {{-- <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('data-provider')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الشركات </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('data-employees')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الموظفين</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('data-subscribers')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>المشتركين</p>
                </a>
              </li> --}}


            {{-- </ul> --}}
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
