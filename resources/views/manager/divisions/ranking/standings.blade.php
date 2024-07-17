@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/standings.js') }}"></script>
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
                    <li>
                        <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li>
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
        <div class="col-12 mt-3">
            <div class="custom-alert alert-tertiary">
                <div class="alert-icon">
                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                </div>
                <div class="alert-text text-dark">
                    <p class="mb-0">Please note that the default scoring system has been used to calculate points scored for the purposes of the overall rankings.</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body text-white">

                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="filter-package">Package:</label>
                                    <select name="package" id="package" class="form-control js-select2">
                                        <option value="">All</option>
                                        @foreach($packages as $id => $package)
                                            <option value="{{ $id }}">{{ $package }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-white">
                            <div class="tab-content" id="info-tabContent">
                                <div class="tab-pane fade show active" id="league-table" role="tabpanel" aria-labelledby="league-table-tab">
                                    <div class="text-white js-data-filter-tabs">
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
                                        <div class="tab-content" id="info-tabContent">
                                            <div class="tab-pane fade show active" id="info-season" role="tabpanel" aria-labelledby="info-season-tab">
                                                <div class="mt-3">
                                                    <div class="table-responsive">
                                                        <table class="table text-center custom-table js-table-filter-season" data-url="{{ route('manage.division.season.standings',['division' => $division ]) }}">
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
                                                        <table class="table text-center custom-table js-table-filter-monthly" data-url="{{ route('manage.division.month.standings',['division' => $division ]) }}">
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
                                                        <table class="table text-center custom-table js-table-filter-weekly" data-url="{{ route('manage.division.week.standings',['division' => $division ]) }}">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push ('modals')
    <div class="modal fade" id="js_team_details_modal" data-url="{{ route('manage.division.standings.team.details',['division' => $division]) }}" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content theme-modal">

                <div class="modal-header pb-0">
                    <h3 class="modal-title js-team-name"></h3>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endpush
