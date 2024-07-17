<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Logo -->
            <div class="content-header-item mr-5">
                <a class="link-effect font-w600" href="{{ route('manager.home.index') }}">
                    <span class="text-dual-primary-dark">fantasy</span><span class="text-primary">league</span>
                </a>
            </div>
            <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <ul class="nav-main-header">
                <li>
                    <a class="active" href="db_corporate.html"><i class="fal fa-rocket"></i> Dashboard</a>
                </li>
                <li class="text-center">
                    <a href=""><i class="fal fa-cog"></i> Settings</a>
                </li>
                <li class="text-right">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fal fa-user"></i>
                        {{ auth()->user()->first_name }}
                    </a>
                    <ul>
                        <li>
                            <a href="">
                                <i class="fal fa-fw fa-desktop mr-5"></i> Frontend
                            </a>
                        </li>
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                <i class="fal fa-fw fa-plus mr-5"></i> More
                            </a>
                            <ul>
                                <li>
                                    <a href="">Dashboard</a>
                                </li>
                                <li>
                                    <a href="">Resources</a>
                                </li>
                            </ul>
                        </li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fal fa-fw fa-sign-out mr-5"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
            <!-- END Header Navigation -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fal fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
