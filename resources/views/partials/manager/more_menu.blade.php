@if(auth()->user()->consumer->divisions->count())
    <a href="{{ route('manage.more.division.index', ['division' => auth()->user()->consumer->divisions->first() ]) }}">
        <span><i class="fas fa-bars"></i></span>
    </a>
@elseif(auth()->user()->consumer->teams->count() && auth()->user()->consumer->teams()->first()->scopeCurrentSeason)
    <a href="{{ route('manage.more.division.index', ['division' => auth()->user()->consumer->teams()->first()->scopeCurrentSeason->division ]) }}">
        <span><i class="fas fa-bars"></i></span>
    </a>
@else
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="has-stepper">
        {{ __('Logout') }}&nbsp;&nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endif