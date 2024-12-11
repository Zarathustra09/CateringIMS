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
        <li class="menu-item {{ Request::is('admin/home') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Catering Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Catering Management</span></li>
        <li class="menu-item {{ Request::is('admin/orders') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-food-menu"></i>
                <div data-i18n="Orders">Orders</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('admin/menus') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dish"></i>
                <div data-i18n="Menus">Menus</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('admin/events') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Events">Events</div>
            </a>
        </li>

        <!-- Clients -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Clients</span></li>
        <li class="menu-item {{ Request::is('admin/clients') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
        </li>

        <!-- Staff -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Staff</span></li>
        <li class="menu-item {{ Request::is('admin/staff') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Staff">Staff</div>
            </a>
        </li>



    </ul>
</aside>
