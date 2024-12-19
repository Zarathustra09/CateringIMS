<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="app-brand-link">
            <img src="{{ asset('img/logo-new.png') }}" alt="Catering Management System Logo" class="app-brand-logo">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>


        <!-- Catering Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Reservation Management</span></li>
        <li class="menu-item {{ Request::is('admin/orders') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Reservations">Reservations</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
            <a href="{{route('admin.service.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-i18n="Services">Services</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.client.*') ? 'active' : '' }}">
            <a href="{{route('admin.client.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
        </li>

        <!-- Inventory Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Inventory Management</span></li>
        <li class="menu-item {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
            <a href="{{route('admin.category.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Categories">Categories</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
            <a href="{{route('admin.inventory.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Inventory">Inventory</div>
            </a>
        </li>



        <!-- Staff -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Staff Management</span></li>
        <li class="menu-item {{ request()->routeIs('admin.employee.*') || request()->routeIs('admin.employee_detail.show') ? 'active' : '' }}">
            <a href="{{route('admin.employee.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Staff">Staff</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('admin/payroll') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                <div data-i18n="Payroll">Payroll</div>
            </a>
        </li>
    </ul>
</aside>
