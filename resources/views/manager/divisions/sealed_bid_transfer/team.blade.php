@extends('layouts.manager')

@include('partials.manager.leagues')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/datatables/jquery.dataTables.min.css')}}">
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
    <script src="{{ asset('js/manager/divisions/sealed_bid_transfer/player.js') }}"></script>
@endpush
    
@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li> <a href="{{ route('manage.transfer.sealed.bid.bids',['division' => $division, 'team' => $team ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
                <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{ $team->name }} ({{  $division->name }}) <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                <li>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"><span class="fl fl-bar"></span></button>
                </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
    @if($round && !$isRoundProcessed)
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 d-lg-none">                        
                                <div class="bg-white">
                                    <div class="data-container-area">
                                        <div class="player-data-container">
                                            <div class="auction-content-wrapper p-4">
                                                @include('manager.divisions.sealed_bid_transfer.tabs.details')
                                            </div>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-lg-6 js-left-pitch-area">
                                <form action="{{ route('manage.transfer.online.sealed.bid.players.store',['division' => $division, 'team' => $team ]) }}" method="POST" class="js-players-bids-create-form">
                                    <input type="hidden" name="json_data" id="json_data">
                                    @csrf
                                    <div class="pitch-layout live-auction js-sealbid-transfer" data-player-details="{{ route('manage.transfer.online.sealed.bid.players.details',['division' => $division, 'team' => $team ]) }}">
                                        <div class="pitch-area">
                                            <div class="pitch-image">
                                                <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.png')}}" data-src="{{ $team->getPitchImageThumb() }}" alt="">
                                            </div>
                                            <div class="pitch-players-standing">
                                                <div class="pitch-player-position-wrapper">
                                                    <div class="player-position-view">
                                                        @foreach($teamPlayers as $playerKey => $playerValue)
                                                            @if($playerValue->count())
                                                                <div class="player-position-grid gutters-tiny has-player" id="js_position_{{strtolower($playerKey)}}">
                                                                    <div class="position-wrapper">
                                                                        <div class="position-action-area">
                                                                            <div>                                                                        
                                                                                @can('isChairmanOrManager', [$division, $team])
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
                                                                        @include('manager.divisions.sealed_bid_transfer.partials.player')
                                                                    @endforeach
                                                                    @if($selectedPlayers->where('position_short',$playerKey)->count())
                                                                        @foreach($selectedPlayers->where('position_short',$playerKey) as $newKey => $newValue)
                                                                            @include('manager.divisions.sealed_bid_transfer.partials.add-player', ['newPlayerId' => $newValue->player_in,'oldPlayerId' => $newValue->player_out])
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="player-position-grid gutters-tiny has-no-player" id="js_position_{{strtolower($playerKey)}}">
                                                                    <div class="position-wrapper">
                                                                        <div class="position-action-area">
                                                                            <div>
                                                                                @can('isChairmanOrManager', [$division, $team])
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
                                                                            @if(!$selectedPlayers->where('position_short',$playerKey)->count())
                                                                                <div>
                                                                                    <span class="standing-view-player-position info-text">This team does not have any {{ player_position_except_code($division->getPositionFullName($playerKey)) }}s</span>
                                                                                </div>
                                                                            @endcan
                                                                        </div>
                                                                    </div>
                                                                    @if($selectedPlayers->where('position_short',$playerKey)->count())
                                                                        @foreach($selectedPlayers->where('position_short',$playerKey) as $newKey => $newValue)
                                                                            @include('manager.divisions.sealed_bid_transfer.partials.add-player', ['newPlayerId' => $newValue->player_in,'oldPlayerId' => $newValue->player_out])
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fixed-bottom-content">
                                            <div class="action-buttons p-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary btn-block js-form-submit">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="js-tabing-details col-lg-6 d-none d-md-block order-first order-sm-first order-md-last">
                                <div class="player-data scrollbar">
                                    <div class="auction-data-container">
                                        @include('manager.divisions.sealed_bid_transfer.tabs.players')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="custom-alert alert-tertiary mt-3">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                                Sealed Bid Round not created yet. Please wait for chairman to create.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@if($round && !$isRoundProcessed)
    @push ('modals')
        @include('manager.divisions.sealed_bid_transfer.partials.create')
        @include('manager.divisions.sealed_bid_transfer.partials.view')
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
                                        <li class="text-center has-dropdown has-arrow">
                                            {{ $team->name }} ({{  $division->name }})
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
                    @include('manager.divisions.sealed_bid_transfer.tabs.players')
                </div>
            </div>
        </div>
    @endpush
@endif