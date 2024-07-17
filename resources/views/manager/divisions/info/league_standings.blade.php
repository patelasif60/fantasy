@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/league_standings.js') }}"></script>
    <script>
        var divisionId = @json($division->id);
    </script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.info',['division' => $division]) }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;League
                    </a>
                </li>
                <li class="text-center">League standings</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.division.info.league.standings.filter',['division' => $division ]) }}">
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

                            <div class="mt-3 mb-5">
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

                            <div class="mt-3 mb-5">
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

                            <div class="mt-3 mb-5">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-weekly">
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
@endsection
