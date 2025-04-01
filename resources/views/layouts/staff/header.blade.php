<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="app-brand-link">
            <img src="{{asset('landingpage/assets/img/logoname.jpg')}}" class="img-fluid" alt="" style="max-height: 70px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-4">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('staff.home') ? 'active' : '' }}">
            <a href="{{route('staff.home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Home">Home</div>
            </a>
        </li>

        <!-- Reservation Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Reservation Management</span></li>
        <li class="menu-item {{ Request()->routeIs('staff.staffreservation*') ? 'active' : '' }}">
            <a href="{{ route('staff.staffreservation.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Reservations">Reservations</div>
            </a>
        </li>

        <!-- Payroll Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Payroll Management</span></li>
        <li class="menu-item {{ request()->routeIs('staff.payroll.index') ? 'active' : '' }}">
            <a href="{{ route('staff.payroll.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                <div data-i18n="StaffDetail">My Payroll</div>
            </a>
        </li>

        <!-- Employee Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Employee Management</span></li>
        <li class="menu-item {{ request()->routeIs('staff.staffdetail.index') ? 'active' : '' }}">
            <a href="{{ route('staff.staffdetail.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="StaffDetail">My Detail</div>
            </a>
        </li>
    </ul>
</aside>
