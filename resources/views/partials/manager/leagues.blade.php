@push('swap-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div id="team-swapping" class="team-swapping js-division-swapping">
                <div class="sliding-area">
                    <div class="sliding-nav">
                        <div class="sliding-items">
                            <div class="owl-carousel js-owl-carousel-leagues-global owl-theme">
                                @foreach(auth()->user()->consumer->ownDivisionWithRegisterTeam() as $ownDivision)
                                    <div class="item sliding-item is-small @if(auth()->user()->can('ownLeaguesNav', $ownDivision)) is-owner @endif">
                                        @if(auth()->user()->can('ownLeaguesNav', $ownDivision))
                                            <a href="{{ \Request::route()->getName() == 'manage.chat.index' ? route(\Request::route()->getName(),['division' => $ownDivision, 'role' => 'chairman']) : route('manage.division.start',['division' => $ownDivision, 'role' => 'chairman']) }}" class="sliding-crest with-shadow @if(isset($division) && $division->id === $ownDivision->id) is-active @endif">

                                        @else
                                            <a href="{{ \Request::route()->getName() == 'manage.chat.index' ? route(\Request::route()->getName(),['division' => $ownDivision, 'role' => 'manager']) : route('manage.division.start',['division' => $ownDivision, 'role' => 'manager']) }}" class="sliding-crest with-shadow @if(isset($division) && $ownDivision->id == $division->id) is-active @endif">
                                        @endif
                                            <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png') }}" data-src="{{ $ownDivision->getDivisionImageThumb() }}" alt="{{ $ownDivision->name }}">
                                        </a>
                                        <div class="crest-title text-white text-center">{{ $ownDivision->name }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
