<!--
                Helper classes

                Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

                Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
                Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
                    - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
            -->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-primary">S</span><span class="text-dual-primary-dark">M</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="/dashboard">
                        <i class="{{config('theme.icon.app')}} text-primary"></i>
                        <span class="font-size-xl text-primary">{{ strtoupper(explode(' ', Config::get('app.name'))[0]) }}</span>
                        <span class="font-size-xl text-dual-primary-dark">{{ strtoupper(explode(' ', Config::get('app.name'))[1]) }}</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent mt-4">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="javascript:void(0)">
                    <img class="img-avatar" src="{{ asset('media/avatars/avatar0.jpg') }}" alt="">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase"
                            href="javascript:void(0)">{{auth()->user()->username}}</a>
                    </li>
                    <li class="list-inline-item">
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="link-effect text-dual-primary-dark" data-toggle="layout"
                            data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                            <i class="si si-drop"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark" href="/logout">
                            <i class="si si-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a class="{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="si si-cup"></i><span class="sidebar-mini-hide">Dashboard</span>
                    </a>
                </li>
                @anygrouppermissions('*.users|*.roles|*.config')
                <li class="nav-main-heading"><span class="sidebar-mini-visible">RP</span><span class="sidebar-mini-hidden">Roles&Permissions</span></li>
                @endanygrouppermissions

                @anypermissions('create.users|read.users|update.users|del.users')
                <li>
                    <a class="{{ request()->is('users') ? ' active' : '' }}" href="{{ route('users.index') }}">
                        <i class="si si-users"></i><span class="sidebar-mini-hide">Users</span>
                    </a>
                </li>
                @endanyppermissions
                @anypermissions('create.roles|read.roles|update.roles|del.roles')
                <li>
                    <a class="{{ request()->is('roles') ? ' active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="fa fa-expeditedssl"></i><span class="sidebar-mini-hide">Roles</span>
                    </a>
                </li>
                @endanyppermissions
                
                @role('developer')
                <li>
                    <a class="{{ request()->is('permissions') ? ' active' : '' }}" href="{{ route('permissions.index') }}">
                        <i class="fa fa-lock"></i><span class="sidebar-mini-hide">Permissions</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('users_permissions') ? ' active' : '' }}" href="{{ route('users_permissions.index') }}">
                        <i class="fa fa-user-secret"></i><span class="sidebar-mini-hide">Users Permissions</span>
                    </a>
                </li>
                @endrole
                @anypermissions('read.configs|update.configs')
                <li>
                    <a class="{{ request()->is('config') ? ' active' : '' }}" href="{{ route('configs.index') }}">
                        <i class="fa fa-cogs"></i><span class="sidebar-mini-hide">Configs</span>
                    </a>
                </li>
                @endanyppermissions
                @permissions('read.view_logs')
                <li>
                    <a class="{{ request()->is('view-logs') ? ' active' : '' }}" href="{{ route('view_logs.show') }}">
                        <i class="fa fa-history"></i><span class="sidebar-mini-hide">View Logs</span>
                    </a>
                </li>
                @endpermissions
                <li class="nav-main-heading"><span class="sidebar-mini-visible">DT</span><span class="sidebar-mini-hidden">DATA</span></li>
                @anypermissions('create.billings|read.billings|update.billings|del.billings')
                <li>
                    <a class="{{ request()->is('*/billings') ? ' active' : '' }}" href="{{ route('billings.index') }}">
                        <i class="{{config('theme.icon.menu_stores')}} mr-2"></i><span class="sidebar-mini-hide">Billings</span>
                    </a>
                </li>
                @endpermissions
                @anypermissions('create.inventory|read.inventory|update.inventory|del.inventory')
                <li>
                    <a class="{{ request()->is('*/inventory') ? ' active' : '' }}" href="{{ route('inventory.index') }}">
                        <i class="{{config('theme.icon.menu_inventory')}} mr-2"></i><span class="sidebar-mini-hide">Inventory</span>
                    </a>
                </li>
                @endpermissions
                @anypermissions('read.orders|update.orders|del.orders')
                <li>
                    <a class="{{ request()->is('*/orders') ? ' active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="{{config('theme.icon.menu_orders')}} mr-2"></i><span class="sidebar-mini-hide">Orders</span>
                    </a>
                </li>
                @endpermissions
                {{-- <li>
                    <a class="{{ request()->is('*/stores') ? ' active' : '' }}" href="{{ route('stores.index') }}">
                        <i class="{{config('theme.icon.menu_stores')}} mr-2"></i><span class="sidebar-mini-hide">Stores</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('*/articles') ? ' active' : '' }}" href="{{ route('articles.index') }}">
                        <i class="{{config('theme.icon.menu_articles')}} mr-2"></i><span class="sidebar-mini-hide">Articles</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('*/inventory') ? ' active' : '' }}" href="{{ route('inventory.index') }}">
                        <i class="{{config('theme.icon.menu_inventory')}} mr-2"></i><span class="sidebar-mini-hide">Inventory</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->is('*/orders') ? ' active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="{{config('theme.icon.menu_orders')}} mr-2"></i><span class="sidebar-mini-hide">Orders</span>
                    </a>
                </li>

                <li class="nav-main-heading"><span class="sidebar-mini-visible">RE</span><span class="sidebar-mini-hidden">Report</span></li>
                <li>
                    <a class="{{ request()->is('*/report') ? ' active' : '' }}" target="_bank" href="{{ route('report.gmlog') }}">
                        <i class="{{config('theme.icon.menu_report')}} mr-2"></i><span class="sidebar-mini-hide">Monthly Report</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('*/report') ? ' active' : '' }}" target="_bank" href="{{ route('report.gdlog') }}">
                        <i class="{{config('theme.icon.menu_report')}} mr-2"></i><span class="sidebar-mini-hide">Daily Report</span>
                    </a> 
                </li>--}}
            </ul>
        </div>
        <!-- END Side Navigation -->
        <div class="clearfix p-4">
            <a class="font-w600" href="#">{{ config('app.version', 'v 1.00.00') }}</a>
        </div>
    </div>
    <!-- Sidebar Content -->
</nav>