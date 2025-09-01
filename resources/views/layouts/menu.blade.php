<!-- Menu Navigation starts -->
    <nav>
      <div class="app-logo">
        <a class="logo d-inline-block" href="{{url('/dashboard')}}">
          <img src="{{ asset('assets/images/logo/RSS_Security_Logo.png') }}" alt="#" style="width: 200px;height:80px">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
      </div>
      <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
          <li class="menu-title">
            <span>Dashboard</span>
          </li>
          <li class="no-sub">
            <a class="" href="{{url('/dashboard')}}">
              <i class="ph-duotone  ph-house-line"></i> dashboard
            </a>
          </li>

          <li>
            <a class="" data-bs-toggle="collapse" href="#employees" aria-expanded="false">
              <i class="ph-duotone  ph-users-four"></i>
              Employee Management
              {{-- <span class="badge text-bg-success badge-notification ms-2">2</span> --}}
            </a>
            <ul class="collapse" id="employees">
              <li><a href="{{url('/employees')}}">Employees List</a></li>
              <li><a href="{{url('/employees/create')}}">Add Employee</a></li>
            </ul>
          </li>

          <li>
            <a class="" data-bs-toggle="collapse" href="#uni-management" aria-expanded="false">
              <i class="ph-duotone  ph-briefcase"></i>
              Uniform Management
              {{-- <span class="badge text-bg-success badge-notification ms-2">2</span> --}}
            </a>
            <ul class="collapse" id="uni-management">
              <li><a href="#">Uniform List</a></li>
              <li><a href="#">Stock Management</a></li>
              <li><a href="#">Add Stock</a></li>
            </ul>
          </li>
          <li class="no-sub">
            <a class="" href="widget.html">
                <i class="ph ph-money"></i> Payroll
              {{-- <i class="ph-duotone  ph-squares-four"></i> Payroll --}}
            </a>
          </li>
        </ul>
      </div>

      <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
      </div>

    </nav>
    <!-- Menu Navigation ends -->
