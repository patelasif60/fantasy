@if (isset ($division))
<div id="sidebar-wrapper" class="sidenav">
    <div class="sidebar-container">
        <ul class="sidebar-nav">
            @can('update', $ownTeam)
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.teams.settings',['division' => $division, 'team' => $ownTeam]) }}" class="sidebar-nav-link">
                    Team Settings
                </a>
            </li>
            @endcan
            @can('update', $division)
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.division.settings.edit',['name' => 'league', 'division' => $division ]) }}" class="sidebar-nav-link d-none d-md-inline-block {{ active('manage.division.settings.edit') }}">
                    League Settings
                </a>
                <a href="{{ route('manage.division.settings',['division' => $division ]) }}" class="sidebar-nav-link d-inlin-block d-md-none {{ active('manage.division.settings') }}">
                    League settings
                </a>
            </li>
            @endcan
            @if (Auth::user()->can('accessAuctionSettings', $division))
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.division.auction.settings',['division' => $division ]) }}" class="sidebar-nav-link {{ active('manage.division.auction.settings') }}">
                    Auction Settings
                </a>
            </li>
            @endif
            <li class="sidebar-nav-item">
                <a href="@if(isset($division) && $division) {{ route('manage.division.createnew', ['division' => $division, 'from' => 'more']) }} @else {{ route('manage.division.create', ['from' => 'more' ]) }} @endif" class="sidebar-nav-link {{ active('manage.division.createnew') }}">
                    Create a New League
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.account.settings') }}" class="sidebar-nav-link {{ active('manage.account.settings') }}">
                    My Account
                </a>
            </li>
        </ul>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('frontend.gameguide') }}" class="sidebar-nav-link" target="_blank">
                    Game Guide
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.division.auction.pdfdownloads',['division' => $division ]) }}" class="sidebar-nav-link {{ active('manage.division.auction.pdfdownloads') }}">
                    Auction Pack
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('manage.contactus') }}" class="sidebar-nav-link {{ active('manage.contactus') }}">
                    Contact Us
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-nav-link">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
@endif
