@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <!-- <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script> -->
    <script src="{{ asset('themes/codebase/js/plugins/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/auction/player.js') }}"></script>
    <script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.auction.offline.index',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                </li>
                <li>{{ $team->name }}</li>
                <li></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        @if(!$team->teamPlayerContracts->count())
        <div class="col-12 mt-3">
            <div class="custom-alert alert-tertiary">
                <div class="alert-icon">
                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                </div>
                <div class="alert-text text-dark">
                    <p class="mb-0">Click icon against position to select players.</p>
                </div>
            </div>
        </div>
        @endif
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 d-lg-none">
                            <div class="bg-white">
                                <div class="data-container-area">
                                    <div class="player-data-container">
                                        <div class="auction-content-wrapper p-2">
                                            <div class="d-flex justify-content-space-between">
                                                <div class="auction-content d-flex">
                                                    <div class="auction-crest mr-2">
                                                        <img src="{{ $team->getCrestImageThumb()}}">
                                                    </div>
                                                    <div class="auction-body">
                                                        <p class="font-weight-bold m-0">{{$team->name}}</p>
                                                        <p class="m-0 small">{{$totalTeamPlayers}} / {{$division->getOptionValue('default_squad_size')}} players</p>
                                                    </div>
                                                </div>

                                                <div class="remaining-budget text-right py-1 px-2">
                                                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                    <p class="m-0 amount">&pound;{{floatval($team->team_budget)}}m</p>
                                                </div>
                                            </div>
                                                <div class="row gutters-sm justify-content-center mt-4">
                                                    <div class="col-12">
                                                        <a href="{{ route('manage.auction.offline.index',['division' => $division ]) }}" class="btn  btn-outline-primary no-shadow btn-block btnSearch">Back to Auction Summary</a>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 js-left-pitch-area">
                            <div class="pitch-layout live-auction">
                                <div class="pitch-area">
                                    <div class="pitch-image">
                                        <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.png')}}" data-src="{{ $team->getPitchImageThumb() }}" alt="">
                                    </div>
                                    <div class="pitch-players-standing">
                                        <div class="pitch-player-position-wrapper">
                                            <div class="player-position-view">
                                                @foreach($teamPlayers as $playerKey => $playerValue)

                                                    @if($playerValue->count())
                                                        <div class="player-position-grid gutters-tiny has-player">
                                                            <div class="position-wrapper">
                                                                <div class="position-action-area">
                                                                    <div>
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0)" class="js-player-positions" data-position="{{$playerKey}}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative">{{$playerKey}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @foreach($playerValue as $key => $value)
                                                                @include('manager.live_offline_auction.partials.player')
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                            <div class="position-wrapper">
                                                                <div class="position-action-area">
                                                                    <div>
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0)" class="js-player-positions" data-position="{{$playerKey}}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative">{{$playerKey}}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="standing-view-player-position info-text">This team does not have any {{ player_position_except_code($division->getPositionFullName($playerKey)) }}s</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="js-player-filters col-lg-6 d-none d-lg-block">
                            <div class="player-data scrollbar">
                                @include('manager.live_offline_auction.partials.player_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('manager.live_offline_auction.partials.detail')
    @include('manager.live_offline_auction.partials.edit')
    @include('manager.live_offline_auction.partials.create')
    <div class="full-screen-modal" id="full-screen-modal" tabindex="-1" role="dialog" aria-labelledby="full-screen-modal" aria-hidden="true">
        <div class="modal-card" role="document">
            <div class="modal-card-head">
                <div class="header">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close">
                                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                        </a>
                                    </li>
                                    <li class="text-center has-dropdown has-arrow">
                                        {{ $team->name }}
                                        <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span>
                                    </li>
                                    <li class="text-right">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-card-body">
                @include('manager.live_offline_auction.partials.player_list')
            </div>
        </div>
    </div>
@endpush

