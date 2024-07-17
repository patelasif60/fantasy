@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/head_to_head.js') }}"></script>
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
                    <a href="{{ route('manage.division.info',['division' => $division]) }}"> <span><i class="fas fa-chevron-left mr-2"></i></span> League </a>
                </li>
                <li class="text-center">Head to head</li>
                <li class="text-right">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button>
                </li>
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
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.division.info.head.to.head.filter',['division' => $division ]) }}">
                    <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-standings-tab" data-toggle="pill" href="#info-standings" role="tab" aria-controls="info-standings" aria-selected="true" data-load="0">Standings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-matches-tab" data-toggle="pill" href="#info-matches" role="tab" aria-controls="info-matches" aria-selected="false" data-load="0">Matches</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-standings" role="tabpanel" aria-labelledby="info-standings-tab">
                            <div class="mt-3 mb-5">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-standings">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-matches" role="tabpanel" aria-labelledby="info-matches-tab">

                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-date-info js-matches-filter owl-theme sliding-items-info">
                                            @foreach($gameweeks as $gameweek)
                                                <div class="item info-block js-matches" data-id="{{ $gameweek->id }}">
                                                    <a href="javascript:void(0)" class="js-gameweek-link info-block-content @if($activeWeekId == $gameweek->id) is-active @endif" data-number="{{ $loop->iteration }}">
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
                                    <table class="table text-center custom-table js-table-filter-matches">
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
