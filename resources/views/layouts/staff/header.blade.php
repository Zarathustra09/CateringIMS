<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="app-brand-link">
            <img src="{{asset('landingpage/assets/img/logoname.jpg')}}" class="img-fluid" alt="" style="max-height: 60px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{route('staff.home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Home">Home</div>
            </a>
        </li>


        <!-- Catering Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Reservation Management</span></li>


        <li class="menu-item {{ Request()->routeIs('staff/reservations') ? 'active' : '' }}">
            <a href="{{ route('staff.staffreservation.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Reservations">Reservations</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Payroll Management</span></li>

        <li class="menu-item {{ Request::is('staff/details') ? 'active' : '' }}">
            <a href="{{ route('staff.staffdetail.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                <div data-i18n="StaffDetail">My Detail</div>
            </a>
        </li>
        
    </ul>
</aside>
