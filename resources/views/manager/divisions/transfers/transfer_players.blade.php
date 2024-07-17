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
    <script src="{{ asset('themes/codebase/js/plugins/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/transfers/transfer_player.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li><a href="{{ route('manage.transfer.teams',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a></li>
                <li>{{ $team->name }}</li>
                <li><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"><span class="fl fl-bar"></span></button></li>
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
                        <div class="col-lg-6 d-lg-none">
                            <div class="bg-white">
                                <div class="data-container-area">
                                    <div class="player-data-container">
                                        <div class="auction-content-wrapper p-2">
                                            <div class="d-flex justify-content-space-between">
                                                <div class="auction-content d-flex">
                                                    <div class="auction-crest mr-2">
                                                        <img src="{{ $team->getCrestImageThumb() }}">
                                                    </div>
                                                    <div class="auction-body">
                                                        <p class="font-weight-bold m-0">{{ $team->name }}</p>
                                                        <p class="m-0 small">{{ $totalTeamPlayers }} / {{ $division->getOptionValue('default_squad_size') }} players</p>
                                                    </div>
                                                </div>
                                                <div class="remaining-budget text-right py-1 px-2">
                                                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                    <p class="m-0 amount">&pound;<span class="js-team-budget">{{ floatval($teamBudget) }}</span>m</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 js-left-pitch-area js-player-out">
                            <div class="pitch-layout live-auction">
                                <div class="pitch-area">
                                    <div class="pitch-image">
                                        <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.svg')}}" data-src="{{ $team->getPitchImageThumb() }}" alt="">
                                    </div>
                                    <div class="pitch-players-standing">
                                        <div class="pitch-player-position-wrapper">
                                            <div class="player-position-view js-player-view">
                                                @foreach($teamPlayers as $playerKey => $playerValue)
                                                    @if($playerValue->count())
                                                        <div class="player-position-grid gutters-tiny has-player">
                                                            <div class="position-wrapper">
                                                                <div class="position-action-area">
                                                                    <div>
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0);" class="js-player-positions" data-position="{{$playerKey}}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower(player_position_short($playerKey))}} position-relative">{{player_position_short($playerKey)}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         @foreach($dbDataArray as $playerDatakey=>$playerDataVal)
                                                                @if($playerDataVal['position'] == player_position_short($playerKey))
                                                                    <div class="player-position-col cursor-pointer playerRadio js-player-radio" data-bought-val="{{$playerDataVal['transferValue'] ? $playerDataVal['transferValue'] : '0.00'}}" data-club-id="{{$playerDataVal['clubId']}}" data-position="{{player_position_short($playerKey)}}" data-team-id="{{$playerDataVal['teamId']}}" data-player-id="{{$playerDataVal['playerId']}}"   id="playerRadio_{{strtolower($playerDataVal['playerId'])}}" name="playerRadio" data-value="{{$playerDataVal['plyerModelName']}}">
                                                                        <div class="player-wrapper auction-player-wrapper">
                                                                            <div class="player-wrapper-img @if(strtolower($playerDataVal['position']) == 'gk') {{  strtolower($playerDataVal['shortCode']) }}_{{ strtolower($playerDataVal['position']) }} @else {{  strtolower($playerDataVal['shortCode']) }}_player @endif">
                                                                                <a href="javascript:void(0);">
                                                                                    <div class="transfer-process">
                                                                                        <span><i class="fas fa-times"></i></span>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <div class="player-wrapper-body">
                                                                                <div class="badge-area">
                                                                                    <div class="custom-badge is-{{strtolower($playerDataVal['position'])}}">{{$playerDataVal['position']}}</div>
                                                                                </div>
                                                                                <div class="player-wrapper-title">{{$playerDataVal['playerName']}}</div>
                                                                                <div class="player-wrapper-description">
                                                                                    <div class="player-wrapper-text">
                                                                                        <div class="player-fixture-sch">
                                                                                            <span class="schedule-day">{{$playerDataVal['shortCode']}}</span>
                                                                                        </div>
                                                                                        <div class="player-points"><span class="points">£{{$playerDataVal['transferValue']?$playerDataVal['transferValue']:'0.00'}}</span>m</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                    @endif
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                            <div class="position-wrapper">
                                                                 <div class="position-action-area">
                                                                    <div>
                                                                        <span class="player-position-indicator">
                                                                            <a href="javascript:void(0);" class="js-player-positions" data-position="{{ $playerKey }}">
                                                                                <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                            </a>
                                                                        </span>
                                                                        <span class="standing-view-player-position is-{{strtolower(player_position_short($playerKey))}}  position-relative">{{player_position_short($playerKey)}}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="standing-view-player-position info-text">This team does not have any {{player_position_except_code($playerKey)}}s</span>
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
                                <div class="fixed-bottom-content">
                                    <div class="action-buttons">
                                        <div class="row">
                                            <div class="col-6">
                                                <form class="js-create-transfer d-none" action="{{ route('manage.division.transfer.transfer_players.store', ['division' => $division, 'team' => $team]) }}" method="POST" >
                                                    @csrf
                                                    <input type="hidden" value="{{$dbDatastr}}" id="dbdata" name="dbdata">
                                                    <input type="hidden" name="teamBudget" id="teamBudget">
                                                    <input type="hidden" id="transferData" name="transferData">
                                                    <input type="hidden" id="oldActiveplayers" name="oldActiveplayers">
                                                </form>
                                                <input type="button" data-url="{{ route('manage.division.transfer.create', ['division' => $division, 'team' => $team]) }}" class="btn btn-primary btn-block js-create-transfer" value="Save">
                                            </div>
                                            <div class="col-6">
                                                <input type="button" class="btn btn-danger btn-block js-revert-data" data-url="{{ route('manage.division.transfer.add_players', ['division' => $division, 'team' => $team]) }}" value="Cancel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="player-data scrollbar">
                                <div class="data-container-area">
                                    <div class="player-data-container auction-data-container">
                                        <div class="auction-content-wrapper p-3">
                                           <div class="d-none d-lg-flex justify-content-space-between">
                                                <div class="auction-content d-flex">
                                                    <div class="auction-crest mr-2">
                                                        <img src="{{ $team->getCrestImageThumb()}}">
                                                    </div>
                                                    <div class="auction-body">
                                                        <p class="font-weight-bold m-0">{{ $team->name }}</p>
                                                        <p class="m-0 small js-count-player">{{ $totalTeamPlayers }} / {{ $division->getOptionValue('default_squad_size') }} players</p>
                                                    </div>
                                                </div>
                                                <div class="remaining-budget text-right py-1 px-2">
                                                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                    <p class="m-0 amount">&pound;<span class="js-team-budget">{{$teamBudget}}</span>m</p>
                                                </div>
                                            </div>     
                                            <div class="row gutters-md mt-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="filter-position">Position:</label>
                                                        <select name="position" id="filter-position" class="form-control js-select2">
                                                            <option value="">All</option>
                                                            @foreach($positions as $id => $value)
                                                                <option value="{{ $id }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="filter-club">Club:</label>
                                                        <select name="club" id="filter-club" class="form-control js-select2">
                                                            <option value="">All</option>
                                                            @foreach($clubs as $id => $club) {
                                                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-0">
                                                        <label for="player_name">Player Name:</label>
                                                        <input type="text" class="form-control" id="player_name" placeholder="Player Name/Code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="player-data-wrapper">
                                            <div class="table-responsive  js-player-in">
                                                <table class="table custom-table manager-teams-list-table has-player-short-code" data-url="{{ route('manage.division.transfer.get.players', ['division' => $division, 'team' => $team]) }}"></table>
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
<div id="transfer_price" class="modal fade nested-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="player-bid-modal-body">
                    <div class="player-bid-modal-content">
                        <div class="player-bid-modal-label">
                            <div class="custom-badge custom-badge-xl is-square positionJs"></div>
                        </div>
                        <div class="player-bid-modal-body">
                            <div class="player-bid-modal-title">Sold</div>
                            <div class="player-bid-modal-text js-player-name"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-group mb-3{{ $errors->has('amount') ? ' is-invalid' : '' }}">    
                            <label for="amount">Enter sold amount (&pound;m)</label>
                            <input type="hidden" name="transferPlayerId" id="transferPlayerId" value="">
                            <input type="hidden" name="clubId" id="clubId" value="">
                            <input type="text" class="form-control" id="transferAmount" name="transferAmount"  placeholder="e.g. 0.5">
                            @if ($errors->has('amount'))
                                <span class="invalid-feedback animated fadeInDown" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row gutters-sm">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block js-submit-transfer"  data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade nested-modal js-create-player-bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="player-bid-modal-body">
                    <form action="{{ route('manage.division.team.auction.create', ['division' => $division, 'team' => $team]) }}" method="POST" class="js-player-bid-create-form">
                        @csrf    
                        <input type="hidden" name="player_id" id="player_id" value="{{ old('player_id') }}">
                        <input type="hidden" name="team_id" id="team_id" value="{{ $team->id }}">
                        <input type="hidden" name="club_id" id="club_id" value="{{ old('club_id') }}">
                        <input type="hidden" name="club_shortCode" id="club_shortCode" value="">
                        <input type="hidden" name="playerNameNoneModel" id="playerNameNoneModel" value="">
                        <div class="player-bid-modal-content">
                            <div class="player-bid-modal-label">
                                <div class="custom-badge custom-badge-xl is-square positionJs"></div>
                            </div>
                            <div class="player-bid-modal-body">
                                <div class="player-bid-modal-title"></div>
                                <div class="player-bid-modal-text"></div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-group mb-3{{ $errors->has('amount') ? ' is-invalid' : '' }}">    
                                <label for="amount">Enter bid amount (&pound;m)</label>
                                <input type="text" class="form-control" id="amount" name="amount" value="0.00">
                            </div>
                            <div class="row gutters-sm">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" data-url="{{ route('manage.division.transfer.add_players', ['division' => $division, 'team' => $team]) }}" class="btn btn-primary btn-block js-transfer-player"  data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div> 
@endpush
