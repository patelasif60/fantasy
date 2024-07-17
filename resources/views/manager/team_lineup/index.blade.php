@extends('layouts.manager')

@include('partials.manager.leagues')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.22/dist/vue.js"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        fitty('.player-wrapper-title', {
            minSize: 7,
            maxSize: 11
        });
    });
    </script>

@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/leaguereports/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/manager/team_lineup/index.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.teams.settings.edit',['division' => $division, 'team' => $team]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;SETTINGS</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{$team->name}} ({{  $division->name }}) <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li>
                        {{-- <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
                            <span><i class="fas fa-bars"></i></span>
                        </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fl fl-bar"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body" id="team-lineup-page">
                    <team-lineup :active-players='{{json_encode($activePlayers)}}' :sub-players='{{json_encode($subPlayers)}}' :division='{{$division}}' :team='{{$team->id}}' :pitch-url='{{ json_encode($pitch) }}' :available-formations=" {{json_encode($availableFormations)}} " :possible-positions=" {{json_encode($minMaxNumberForPosition)}} " :team-clubs=" {{json_encode($teamClubs)}} " :future-fixtures-dates=" {{json_encode($futureFixturesDates)}} " :team-stats="{{ json_encode($teamStats) }}" :seasons="{{json_encode($seasons)}}" :current-season="{{ json_encode($currentSeason) }}" :player-season-stats="{{json_encode($playerSeasonStats)}}" :own-team="{{ json_encode($ownTeamFlg) }}" :allow-weekend-swap="{{ json_encode($allowWeekendSwap) }}" :is-supersub-disabled="{{ json_encode($isSupersubDisabled) }}" :enable-supersubs="{{ json_encode($enableSupersubs) }}" :allow-weekend-changes="{{ json_encode($allowWeekendChanges) }}" :supersub-feature-live='{{$supersub_feature_live}}' :super-sub-fixture-dates="{{ json_encode($superSubFixtureDates) }}" :columns="{{ json_encode($columns) }}"></team-lineup>
                </div>
            </div>
        </div>
    </div>
@endsection
