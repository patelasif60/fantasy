@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
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
                        <a href="{{ route('manage.teams.settings',['division' => $division, 'team' => $team]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="text-center">{{ $team->name }}</li>
                    <li class="text-right"></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row no-gutters">
                        <div class="col-12 is-sticky" id="lineUp-Details">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Lineup-tab" data-toggle="pill" href="#Lineup" role="tab" aria-controls="Lineup" aria-selected="true">Lineup</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <div class="tab-content" id="team-lineup-page">
                                <div class="tab-pane fade show active" id="Lineup" role="tabpanel" aria-labelledby="Lineup-tab">
                                    <team-lineup :active-players='{{ json_encode($activePlayers) }}' :sub-players='{{ json_encode($subPlayers) }}' :pitch-url='{{ json_encode($pitch) }}' is-player-moveable="false"></team-lineup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
