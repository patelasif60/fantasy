@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/plugins/datatables/datatables.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/league_standings.js') }}"></script>
    <script>
        var divisionId = @json($division->id);
    </script>
@endpush

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li> <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
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
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="league-table-tab" data-toggle="pill" href="#league-table" role="tab" aria-controls="league-table" aria-selected="true" data-load="0">League</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="league-competitions-tab" data-toggle="pill" href="#league-competitions" role="tab" aria-controls="league-competitions" aria-selected="false" data-load="0">COMPS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fl-competitions-tab" data-toggle="pill" href="#fl-competitions" role="tab" aria-controls="fl-competitions" aria-selected="false" data-load="0">FL COMPS</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="info-tabContent">
                                <div class="tab-pane fade show active" id="league-table" role="tabpanel" aria-labelledby="league-table-tab">
                                    <div class="text-white js-data-filter-tabs" data-url="{{ route('manage.division.info.league.standings.filter',['division' => $division ]) }}">
                                        <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-season-tab" data-toggle="pill" href="#info-season" role="tab" aria-controls="info-season" aria-selected="true" data-load="0">Season</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="info-monthly-tab" data-toggle="pill" href="#info-monthly" role="tab" aria-controls="info-monthly" aria-selected="false" data-load="0">Month</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="info-weekly-tab" data-toggle="pill" href="#info-weekly" role="tab" aria-controls="info-weekly" aria-selected="false" data-load="0">Week</a>
                                            </li>
                                        </ul>
                                        @if(strip_tags(setting('league_info_message')))
                                        <div class="col-12 mt-3">
                                            <div class="custom-alert alert-tertiary league-message">
                                                <div class="alert-icon">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                                </div>
                                                <div class="alert-text text-dark js-content-message text-truncate">
                                                    <div>
                                                        {!! setting('league_info_message') !!}
                                                    </div>
                                                </div>
                                                <div class="alert-icon cursor-pointer ml-1 js-plus-icon">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/plus.svg') }}" alt="alert-img">
                                                </div>
                                                <div class="alert-icon cursor-pointer ml-1 js-minus-icon d-none">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/minus.svg') }}" alt="alert-img">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($division->introduction)
                                        <div class="col-12 mt-3">
                                            <div class="custom-alert alert-secondary league-message">
                                                <div class="alert-icon">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                                </div>
                                                <div class="alert-text text-dark js-content-message text-truncate">
                                                    <div class="flex-fill">
                                                        <span class="font-weight-bold mr-1 float-left">Chairman's message:</span> {!! $division->introduction !!}
                                                    </div>
                                                </div>
                                                 <div class="alert-icon cursor-pointer ml-1 js-plus-icon">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/plus.svg') }}" alt="alert-img">
                                                </div>
                                                <div class="alert-icon cursor-pointer ml-1 js-minus-icon d-none">
                                                    <img  src="{{ asset('/assets/frontend/img/cta/minus.svg') }}" alt="alert-img">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="tab-content" id="info-tabContent">
                                            <div class="tab-pane fade show active" id="info-season" role="tabpanel" aria-labelledby="info-season-tab">
                                                <div class="mt-3">
                                                    <div class="table-responsive">
                                                        <table class="table text-center custom-table js-table-filter-season">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="info-monthly" role="tabpanel" aria-labelledby="info-monthly-tab">
                                                <div class="sliding-area">
                                                    <div class="sliding-nav">
                                                        <div class="sliding-items">
                                                            <div class="owl-carousel js-owl-carousel-date-info js-month-year-filter owl-theme sliding-items-info">
                                                                @foreach($months as $month)
                                                                    <div class="item info-block js-month" data-start-date="{{ $month['startDate']->format('Y-m-d') }}" data-end-date="{{ $month['endDate']->format('Y-m-d') }}">
                                                                        <a href="javascript:void(0)" class="js-month-link info-block-content  @if(date('M') == $month['startDate']->format('M')) is-active @endif" data-number="{{ $loop->iteration }}">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    {{ $month['startDate']->format('M') }}
                                                                                </div>
                                                                                <div class="desc">
                                                                                    {{ $month['startDate']->format('Y') }}
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <div class="table-responsive">
                                                        <table class="table text-center custom-table js-table-filter-monthly">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="info-weekly" role="tabpanel" aria-labelledby="info-weekly-tab">
                                                <div class="sliding-area">
                                                    <div class="sliding-nav">
                                                        <div class="sliding-items">
                                                            <div class="owl-carousel js-owl-carousel-date-info js-week-filter owl-theme sliding-items-info">
                                                                @foreach($gameweeks as $gameweek)
                                                                    <div class="item info-block js-week" data-start-date="{{ $gameweek->start->format('Y-m-d') }}" data-end-date="{{ $gameweek->end->format('Y-m-d') }}">
                                                                        <a href="javascript:void(0)" class="js-week-link info-block-content @if($gameweek->id === $activeWeekId) is-active @endif" data-number="{{ $loop->iteration }}">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    {{ $gameweek->number }}
                                                                                </div>
                                                                                <div class="desc">
                                                                                    Week
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="table-responsive">
                                                        <table class="table text-center custom-table js-table-filter-weekly">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="league-competitions" role="tabpanel" aria-labelledby="league-competitions-tab">
                                    <ul class="custom-list-group list-group-white">

                                        @can('allowHeadToHead',$division)
                                        <li>
                                            <div class="list-element">
                                                <a href="@can('accessTab', $division) {{ route('manage.division.info.head.to.head',['division' => $division]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">Head to head</span></a>
                                            </div>
                                        </li>
                                         @endcan
                                        @can('allowFaCup', $division)
                                        <li>
                                            <div class="list-element">
                                                <a href="@can('accessTab', $division) {{ route('manage.division.info.fa.cup',['division' => $division]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">FA Cup</span></a>
                                            </div>
                                        </li>
                                        @endcan

                                        @can('allowCustomCup', $division)
                                            @if ($customCups)
                                                @foreach($customCups as $customCup)
                                                    <li>
                                                        <div class="list-element">
                                                            <a href="@can('accessTab', $division) {{ route('manage.league.customcupfixture',['division' => $division , 'customCup' => $customCup ]) }} @else {{ route('manage.league.customcupfixture',['division' => $division , 'customCup' => $customCup ]) }} @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">{{ $customCup->name }} </span></a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endcan

                                        {{-- <li>
                                            <div class="list-element">
                                                <a href="#" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">Linked League 1</span></a>
                                            </div>
                                        </li> --}}
                                        <li>
                                            <div class="list-element">
                                                {{-- <a href="@can('accessTab', $division) {{ route('manage.leaguereports',['division' => $division ]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">League report</span></a> --}}
                                                <a href="#" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot" id="league-competitions-tab" data-toggle="modal" data-target="#league_competition"><span class="has-icon">League report</span></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <a href="{{ route('manage.division.halloffame',['division' => $division ]) }}" class="has-stepper"><span class="has-icon">Hall of fame</span></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <a href="{{ route('manage.linked.league.list',['division' => $division ]) }}" class="has-stepper"><span class="has-icon">Linked League</span></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="fl-competitions" role="tabpanel" aria-labelledby="fl-competitions-tab">
                                    <ul class="custom-list-group list-group-white">
                                        @can('allowChampionLeague', $division)
                                             @if ($championLeague)
                                               <li>
                                                <div class="list-element">
                                                    <a href="@can('accessTab', $division) {{ route('manage.league.champion.phases',['division' => $division ]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">Champions League</span></a>
                                                </div>
                                                </li>
                                             @endif
                                        @endcan
                                        @can('allowEuropaLeague', $division)
                                             @if ($europaLeague)
                                               <li>
                                                <div class="list-element">
                                                    <a href="@can('accessTab', $division) {{ route('manage.league.europa.phases',['division' => $division ]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">Europa League</span></a>
                                                </div>
                                                </li>
                                             @endif
                                        @endcan
                                        @can('allowProCup', $division)
                                            @if ($userHasProcupFixture)
                                                <li>
                                                    <div class="list-element">
                                                        <a href="@can('accessTab', $division) {{ route('manage.league.procupfixture',['division' => $division ]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division) text-dark @endcannot"><span class="has-icon">Pro Cup</span></a>
                                                    </div>
                                                </li>
                                            @endif
                                        @endcan
                                        <li>
                                            <div class="list-element">
                                                <a href="{{ route('manage.division.standings', ['division' =>  $division]) }}" class="has-stepper"><span class="has-icon">Rankings</span></a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="league_competition" class="modal fade" role="dialog">>
        <div class="modal-dialog" role="document">
            <div class="modal-content theme-modal">
                <div class="modal-close-area">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                    <div class="f-12">Close</div>
                 </div>
                 <div class="modal-header">
                    <h5 class="modal-title">League Report</h5>
                 </div>
                 <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            Coming soon...
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
@endsection
