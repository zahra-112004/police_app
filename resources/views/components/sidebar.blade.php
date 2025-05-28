<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="d-flex align-items-center gap-2 px-3 py-3 text-decoration-none">
                <img src="{{ asset('/assets/images/logos/logo.jpg') }}" alt="Logo" style="height: 50px;">
                <span style="font-family: 'Poppins', sans-serif; font-size: 20px; color: rgb(105, 20, 120); text-transform: uppercase; font-weight: 700; letter-spacing: 2px;">Police App</span>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/panel-control/dashboard') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/panel-control/vehicles') }}" aria-expanded="false">
                        <i class="ti ti-car"></i>
                        <span class="hide-menu">Vehicles</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>