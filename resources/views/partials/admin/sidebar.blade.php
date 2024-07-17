<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header content-header-fullrow px-15">
                <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fal fa-times text-danger"></i>
                    </button>
                    <!-- END Close Sidebar -->

                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700" href="{{ route('admin.dashboard.index') }}">
                            <span class="font-size-xl text-dual-primary-dark">fantasy</span><span class="font-size-xl text-primary">league</span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side User -->
            <div class="content-side content-side-full content-side-user px-10 align-parent">
                <div class="sidebar-mini-hidden-b text-center">
                    <a class="img-link" href="{{ route('admin.users.profile') }}">
                        <i class="fal fa-user-circle fa-4x"></i>
                    </a>
                    <ul class="list-unstyled mt-10">
                        <li>
                            <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="#">
                                {{ auth()->user()->first_name }}
                            </a>
                        </li>
                        <li>
                            <span class="text-muted font-size-xs text-uppercase">{{ auth()->user()->roles()->first()->display_name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END Side User -->

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li>
                        <a href="{{ route('admin.dashboard.index') }}" class="{{ active('admin.dashboard.index') }}">
                            <i class="fal fa-fw fa-analytics"></i>Dashboard
                        </a>
                    </li>
                    <li class="{{ active('admin.users.*', 'open') }}">
                        <a class="nav-submenu {{ active('admin.users.*') }}" data-toggle="nav-submenu" href="#">
                            <i class="fal fa-fw fa-users"></i>Users
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.users.admin.index') }}" class="{{ active('admin.users.admin.*') }}">Admin users</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.consumers.index') }}" class="{{ active('admin.users.consumers.*') }}">Consumer users</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.divisions.index') }}" class="{{ active('admin.divisions.index') }}">
                            <i class="fal fa-fw fa-sitemap"></i>Leagues
                        <a href="{{ route('admin.teams.index') }}" class="{{ active('admin.teams.*') }}">
                            <i class="fal fa-fw fa-grip-horizontal"></i>Teams
                        </a>
                    </li>
                    <li class="nav-main-heading">System data</li>
                    <li>
                        <a href="{{ route('admin.clubs.index') }}" class="{{ active('admin.clubs.*') }}">
                            <i class="fal fa-fw fa-shield"></i> Clubs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.seasons.index') }}" class="{{ active('admin.seasons.*') }}">
                            <i class="fal fa-fw fa-award"></i> Seasons
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.players.index') }}" class="{{ active('admin.players.*') }}">
                            <i class="fal fa-fw fa-users"></i> Players
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fixtures.index') }}" class="{{ active('admin.fixtures.*') }}">
                            <i class="fal fa-fw fa-calendar-alt"></i> Fixtures
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.packages.index') }}" class="{{ active('admin.packages.*') }}">
                            <i class="fal fa-fw fa-cubes"></i> Packages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.prizepacks.index') }}" class="{{ active('admin.prizepacks.*') }}">
                            <i class="fal fa-fw fa-gift"></i> Prize Packs
                        </a>
                    </li>
                    <li class="{{ active(['admin.options.*', 'admin.pitches.*'], 'open') }}">
                        <a class="nav-submenu {{ active('admin.options.crests.*') }} {{ active('admin.pitches.*') }}" data-toggle="nav-submenu" href="#">
                            <i class="fal fa-fw fa-cog"></i>Options
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.options.crests.index') }}" class="{{ active('admin.options.crests.*') }}">Badges</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.pitches.index') }}" class="{{ active('admin.pitches.*') }}">Pitches</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.gameguide.index') }}" class="{{ active('admin.gameguide.*') }}">
                            <i class="fal fa-fw fa-futbol"></i> GameGuide
                        </a>
                    </li>
                    <li class="{{ active(['admin.message.*'], 'open') }}">
                        <a class="nav-submenu {{ active('admin.message.*') }}" data-toggle="nav-submenu" href="#">
                            <i class="fal fa-fw fa-envelope"></i>Message
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.message.edit',['key' => 'league_info_message']) }}" class="{{ active('admin.message.*') }}">League info</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
