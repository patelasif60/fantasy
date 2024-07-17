@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <style type="text/css">
        .manager-teams-list-table tbody .text-right-padding {
            padding-right: 20px !important;
        }
    </style>
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/more/pltable.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/more/injuries.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/more/players.js') }}"></script>
@endpush

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li> <a href="{{ route('manage.division.info', ['division' => $division]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button> </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body text-white">
                {{-- <h4 class="my-4 text-center">Matches</h4> --}}
                <div class="text-white js-data-filter-tabs">
                    <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary my-0" id="info-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="fixtures-tab" data-toggle="pill" href="#fixtures" role="tab" aria-controls="fixtures" aria-selected="true" data-load="0">Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="players-tab" data-toggle="pill" href="#players" role="tab" aria-controls="player" aria-selected="false" data-load="0">Players</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="injuries-tab" data-toggle="pill" href="#injuries" role="tab" aria-controls="injuries" aria-selected="false" data-load="0">Injuries & Suspensions</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link disabled" id="premierleague-tab" data-toggle="pill" href="#premierleague" role="tab" aria-controls="premierleague" aria-selected="false" data-load="0">PL table</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2" id="info-tabContent">
                        <div class="tab-pane fade show active" id="fixtures" role="tabpanel" aria-labelledby="fixtures-tab">
                            <div class="schedule-supersub">
                                <div class="sliding-area">
                                    <div class="sliding-nav">
                                        <div class="sliding-items">
                                            <div class="owl-carousel js-owl-carousel-date-info js-month-year-filter owl-theme sliding-items-info">
                                                @foreach($gameWeeks as $gameWeek)
                                                    <div class="item info-block js-month" data-id="{{$gameWeek->id}}">
                                                        <a href="javascript:void(0)" class="info-block-content jsGameWeekHandler @if($gameWeek->number == $currentGameWeek->number) is-active @endif" data-url="{{ route('manage.gameWeek.matches',['division' => $division, 'gameWeek' => $gameWeek->id ]) }}" data-number="{{ $loop->iteration }}">
                                                            <div class="block-section">
                                                                <div class="title">
                                                                    Week
                                                                </div>
                                                                <div class="desc">
                                                                    {{$gameWeek->number}}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="matchDetails mt-4">
                                @include('manager.matches.elements.match_card')
                            </div>

                        </div>
                        <div class="tab-pane fade" id="premierleague" role="tabpanel" aria-labelledby="premierleague-tab" data-url="{{ route('manage.pltable.stats',['division' => $division]) }}">
                            The Premier League table will appear here...
                        </div>
                        <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="players-tab">
                            <br>
                            <div class="row justify-content-end mb-3">
                                <div class="col-md-4 col-lg-4">
                                    <button type="button" class="js-insout-btn btn btn-secondary btn-block btn-InsOuts active mb-1">ins and outs</button>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <button type="button" class="js-injuries-btn btn btn-secondary btn-block mb-1" id="injuries-tab" data-load="0">Injuries & Suspensions</button>
                                </div>
                                <div class="col-md-5 col-lg-4">
                                    <button type="button" class="js-overall-history-btn btn btn-secondary btn-block">Overall Player History </button>
                                </div>
                                <div class="col-md-5 col-lg-4">
                                    <button type="button" data-toggle="modal" data-target="#PrintableListModal" class="btn btn-secondary btn-block"><i class="fas fa-file-download mr-2"></i>Download player list</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-white js-table-one">
                                    
                                    <form action="#" class="js-player-filter-form" method="POST">
                                        <div class="block">
                                            <div class="block-content block-content-full">
                                                <div class="form-group row">
                                                    <div class="col-6 js-posotion-filter">
                                                        <label for="filter-position">Position:</label>
                                                        <select name="position" id="filter-position" class="form-control js-select2">
                                                            <option value="">All</option>
                                                            @foreach($positions as $id => $type)
                                                                 <option value="{{ $id }}">{{ player_position_except_code($id) }}s ({{ $division->getPositionShortCode(player_position_short($id))  }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6 d-none js-seson-filter">
                                                        <label for="filter-season">Season:</label>
                                                        <select name="season" id="filter-season" class="form-control js-select2">
                                                            <option value="">All</option>
                                                            @foreach($season as $id => $season){
                                                                 <option value="{{ $season->id }}">{{ $season->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6" id="filter-club">
                                                        <label for="filter-club-id">Club:</label>
                                                        <select name="club" id="filter-club-id" class="form-control js-select2">
                                                            <option value="">All</option>
                                                            @foreach($clubs as $id => $club){
                                                                 <option value="{{ $club->id }}">{{ $club->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="js-player-data  table table-vcenter table-hover custom-table manager-teams-list-table mt-100 player-list-mobile-arrow-disabled" data-url="{{ route('manage.more.players.data',['division' => $division]) }}"></table>
                                    <table class="js-ins-outs d-none table table-vcenter table-hover custom-table manager-ins-out-table mt-100 player-list-mobile-arrow-disabled" data-url="{{ route('manage.more.insout.data',['division' => $division]) }}"></table>
                                     <table class="js-overall-history d-none table table-vcenter table-hover custom-table manager-overall-history mt-100 player-list-mobile-arrow-disabled" data-url="{{ route('manage.more.history.playerdata',['division' => $division]) }}"> <div class="js-overall-history">Player History only includes players on the player list during the 2019/20 season</div></table>
                                </div>

                                <div class="col-12 js-Injuries" id="injuries">
                                    <table class="js-temp-injuries table table-vcenter table-hover custom-table injured-players-table mt-100 player-list-mobile-arrow-disabled" data-url="{{ route('manage.injuries.suspensions',['division' => $division]) }}"></table>

                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="injuries" role="tabpanel" aria-labelledby="injuries-tab">
                            <table class="table table-vcenter table-hover custom-table injured-players-table mt-100 player-list-mobile-arrow-disabled" data-url="{{ route('manage.injuries.suspensions',['division' => $division]) }}"></table>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade fixtureModal" id="matchDetailsModal" tabindex="-1" role="dialog" aria-labelledby="fixtureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom">
                <h6 class="m-0">Match Details</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('modals')
<div class="modal fade" id="PrintableListModal" tabindex="-1" role="dialog" aria-labelledby="PrintableListModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Printable player list</h5>
            </div>
            <div class="modal-body">
                <p>
                    You can download a copy of the player list in PDF or Excel format
                </p>
                <p class='printable-links'><a href="{{route('manage.more.players.export_pdf',['division' => $division])}}">Download Excel</a><br><a href="{{route('manage.more.players.export_xlsx',['division' => $division])}}">Download PDF</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="js_player_details_modal" data-url="{{ route('manage.more.players.data.details',['division' => $division]) }}" role="dialog" aria-labelledby="PrintableListModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-body p-1">
                <div class="p-2">
                    <i class="fa fa-cog fa-spin"></i> Getting data...
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
