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
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;League</a>
                    </li>
                    <li>League report</li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
<!-- Icon Navigation -->
    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item get-division-detail" data-url="{{ route('manage.leaguereports.division',['division' => $division]) }}"  tab-container=".league-container">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#leaguereports-league" role="tab" aria-controls="pills-home" aria-selected="true">League</a>
                                </li>
                                <li class="nav-item get-division-detail" data-url="{{ route('manage.leaguereports.team',['division' => $division]) }}" tab-container=".teams-container">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#leaguereports-teams" role="tab" aria-controls="pills-profile" aria-selected="false">Teams</a>
                                </li>
                                <li class="nav-item get-division-detail" data-url="{{ route('manage.leaguereports.player',['division' => $division]) }}"  tab-container=".players-container">
                                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#leaguereports-players" role="tab" aria-controls="pills-contact" aria-selected="false">Players</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active league-container" id="leaguereports-league" role="tabpanel" aria-labelledby="pills-home-tab">
                                    @include('manager.leaguereports.league')
                                </div>
                                <div class="tab-pane fade" id="leaguereports-teams" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="sliding-area">
                                        <div class="sliding-nav">
                                            <div class="sliding-items">
                                                <div class="owl-carousel js-owl-carousel-division-crest owl-theme">
                                                    @foreach($division->divisionTeams as $divisionTeam)
                                                        <div class="item sliding-item is-small">
                                                            <a href="javascript:void(0)" data-url="{{ route('manage.leaguereports.team',['division' => $division->id , 'team' => $divisionTeam->id ]) }}" tab-container=".teams-container" class="sliding-crest with-shadow get-division-detail @if ($loop->first) active-crest @endif">
                                                            <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{$divisionTeam->getCrestImageThumb()}}" alt="">
                                                            </a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="teams-container">
                                    </div>
                                </div>
                                <div class="tab-pane fade players-container" id="leaguereports-players" role="tabpanel" aria-labelledby="pills-contact-tab"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="division_id" name="division_id" value="{{$division->id}}">
</div>
@endsection
