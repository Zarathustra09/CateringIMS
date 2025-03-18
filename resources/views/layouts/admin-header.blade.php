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
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Catering Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Reservation Management</span></li>

        <!-- Reservation Management -->
        <li class="menu-item {{ request()->routeIs('admin.reservationitems.index','admin.client.index', 'admin.payment.index', 'admin.reservationitems.show') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Reservation Management">Reservation</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.reservationitems.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.reservationitems.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-list-ul"></i>
                        <div data-i18n="Reservations">Reservations</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.client.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.client.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-circle"></i>
                        <div data-i18n="Clients">Clients</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.payment.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.payment.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-money"></i>
                        <div data-i18n="Payment">Payment</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Inventory Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Inventory Management</span></li>
        <li class="menu-item {{ request()->routeIs('admin.category.index', 'admin.inventory.index', 'admin.log.index') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Inventory Management">Inventory</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-category"></i>
                        <div data-i18n="Categories">Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.inventory.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-box"></i>
                        <div data-i18n="Inventory">Items</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.log.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.log.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-history"></i>
                        <div data-i18n="Logs">Logs</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Staff Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Staff Management</span></li>
        <li class="menu-item {{ request()->routeIs('admin.employee.index', 'admin.payroll.index') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Staff Management">Staff</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.employee.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.employee.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-check"></i>
                        <div data-i18n="Staff">Staff</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.payroll.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.payroll.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                        <div data-i18n="Payroll">Payroll</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Service Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Service Management</span></li>
        <li class="menu-item {{ request()->routeIs('admin.service.index', 'admin.categoryevents.index', 'menus.index') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Service Management">Service</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.service.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.service.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                        <div data-i18n="Services">Services</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.categoryevents.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.categoryevents.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-category"></i>
                        <div data-i18n="Category Events">Category Events</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('menus.index') ? 'active' : '' }}">
                    <a href="{{ route('menus.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-food-menu"></i>
                        <div data-i18n="Menu">Menu</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
