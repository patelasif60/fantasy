@extends('layouts.manager')

@include('partials.manager.leagues')

@can('isChairmanOrManager',[$division, $team])

    @push('plugin-styles')
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
        <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/plugins/datatables/datatables.min.css') }}">
    @endpush

    @push('plugin-scripts')
        <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/lodash/lodash.min.js') }}"></script>
        <script src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    @endpush

    @push('page-scripts')
        <script src="{{ asset('js/manager/divisions/online_sealed_bid/player.js') }}"></script>
        <script src="{{ asset('js/manager/divisions/online_sealed_bid/bids.js') }}"></script>
        <script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
    @endpush

@endcan

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.auction.online.sealed.bid.index',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                </li>
                <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{ $team->name }} ({{  $division->name }}) <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                <li></li>
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
                @can('ownTeam',$team)
                    @if(! $team->squadSize && ! $team->squadSizeSealBid)
                        <div class="custom-alert alert-tertiary mt-3">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                                To enter bids click the icon against any position
                            </div>
                        </div>
                    @endif
                @endcan
                <div class="row no-gutters">
                    <div class="col-lg-6 d-lg-none">                        
                        <div class="bg-white">
                            <div class="data-container-area">
                                <div class="player-data-container">
                                    <div class="auction-content-wrapper p-3">
                                        @include('manager.divisions.online_sealed_bid.tabs.details')
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
                                                                    @can('ownTeam', $team)
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0)" class="js-player-positions" data-position="{{ $playerKey }}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative">{{$playerKey}}</span>
                                                                    @else
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative pl-2">{{$playerKey}}</span>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @foreach($playerValue as $key => $value)
                                                            @include('manager.divisions.online_sealed_bid.partials.player')
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <div>
                                                                    @can('ownTeam', $team)
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0)" class="js-player-positions" data-position="{{ $playerKey }}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative">{{$playerKey}}</span>
                                                                    @else
                                                                        <span class="standing-view-player-position is-{{strtolower($playerKey)}} position-relative pl-2">{{$playerKey}}</span>
                                                                    @endcan
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
                    <div class="js-tabing-details col-lg-6 d-none d-md-block order-first order-sm-first order-md-last">
                        @can('ownTeam', $team)
                            <div class="player-data scrollbar">
                                <div class="p-4 js-tabs-area">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary my-0 f-12 rounded-0" id="pills-tab-1" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link px-1" href="{{ route('manage.auction.online.sealed.bid.index',['division' => $division, 'team' => $team ]) }}">Teams</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link @if(isset($data['tab']) && $data['tab'] == 'bids') active @endif" id="bid-tab" data-toggle="pill" href="#bidData" role="tab" aria-controls="bidData" aria-selected="false">Bids</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link  @if(isset($data['tab']) && ( $data['tab'] == 'players' || $data['tab'] == '' ) ) active @endif" id="player-tab" data-toggle="pill" href="#playerData" role="tab" aria-controls="playerData" aria-selected="true">Players</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="auction-data-container">
                                    <div class="tab-content" id="pills-tabContent-1">
                                        <div class="tab-pane fade" id="teamData" role="tabpanel" aria-labelledby="team-tab">Team data</div>
                                        <div class="tab-pane fade @if(isset($data['tab']) && $data['tab'] == 'bids') show active @endif" id="bidData" role="tabpanel" aria-labelledby="bid-tab">
                                            @include('manager.divisions.online_sealed_bid.tabs.bids')
                                        </div>
                                        <div class="tab-pane fade @if(isset($data['tab']) && ( $data['tab'] == 'players' || $data['tab'] == '' )) show active @endif" id="playerData" role="tabpanel" aria-labelledby="player-tab">
                                            @include('manager.divisions.online_sealed_bid.tabs.players')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="player-data">
                                <div class="data-container-area">
                                    <div class="player-data-container">
                                        <div class="auction-content-wrapper px-4 pb-4 pt-3">
                                            @include('manager.divisions.online_sealed_bid.tabs.details')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@can('ownTeam', $team)

    @push ('modals')

    @include('manager.divisions.online_sealed_bid.partials.create')
    @include('manager.divisions.online_sealed_bid.partials.view')
    @include('manager.divisions.online_sealed_bid.partials.edit')

    <div class="full-screen-modal" id="full-screen-modal-mobile" tabindex="-1" role="dialog" aria-labelledby="full-screen-modal" aria-hidden="true">
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
                                    <li class="text-center has-dropdown has-arrow">{{ $team->name }} </li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-card-body">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary my-1 f-12 rounded-0" id="pills-tab-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-1" href="{{ route('manage.auction.online.sealed.bid.index',['division' => $division, 'team' => $team ]) }}" >Teams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bid-tab" data-toggle="pill" href="#bidData" role="tab" aria-controls="bidData" aria-selected="false">Bids</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="player-tab" data-toggle="pill" href="#playerData" role="tab" aria-controls="playerData" aria-selected="true">Players</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent-1">
                    <div class="tab-pane fade" id="bidData" role="tabpanel" aria-labelledby="bid-tab">
                        @include('manager.divisions.online_sealed_bid.tabs.bids')
                    </div>
                    <div class="tab-pane fade show active" id="playerData" role="tabpanel" aria-labelledby="player-tab">
                        @include('manager.divisions.online_sealed_bid.tabs.players')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endpush

@endcan
