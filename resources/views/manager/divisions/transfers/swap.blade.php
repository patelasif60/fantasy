@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/lodash/lodash.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/transfers/swap.js') }}"></script>
@endpush

@push('header-content')
    {{-- @include('partials.auth.header') --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.transfer.index', ['division' => $division]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li>Swap Deals</li>
                    <li class="text-right">
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
        <div class="col-12">
            <div class="container-wrapper">

                    <div class="container-body">
                        <div class="row mt-1">
                            <div class="col-12">

                                <form action="" method="POST" class="js-player-swap-form">
                                @csrf
                                    <div class="row gutters-sm text-white">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="team1">Team</label>
                                                <select class="custom-select js-select2" id="team1" name="teamOut">
                                                    <option value="">Select team</option>
                                                    @foreach($divisionTeams as $key => $team)
                                                        <option data-team-id="{{$team->id}}" data-team-name="{{$team->name}}" value="{{$team->id}}">{{$team->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="player1">Player</label>
                                                <select class="custom-select js-select2" id="player1" name="playerOut">
                                                    <option value="">Select player</option>
                                                    {{-- @foreach($players as $key => $player)
                                                        <option data-team-id="{{$player->team_id}}" data-team-name="{{$player->team_name}}" data-player-id="{{$player->player_id}}"  data-player-name="{{ $player->player_first_name.' '.$player->player_last_name}}" data-manager-name="{{ $player->manager_first_name.' '.$player->manager_last_name}}" value="{{$player->player_id}}">{{get_player_name('fullName', $player->player_first_name, $player->player_last_name)}} ({{$player->club_short_code}}) {{player_position_short($player->position)}} - {{$player->team_name}} </option>
                                                     @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="outSwapAmount">+ Cash (£m)</label>
                                                <input type="text" class="form-control" id="outSwapAmount" name="outSwapAmount" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="player-transfer-icon text-center">
                                        <img src="{{ asset('assets/frontend/img/transfer/icon-swap-white.png')}}" alt="swap-icon">
                                    </div>

                                    <div class="row gutters-sm text-white">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="team2">Team</label>
                                                <select class="custom-select js-select2" id="team2" name="teamIn">
                                                    <option value="">Select team</option>
                                                    @foreach($divisionTeams as $key => $team)
                                                        <option data-team-id="{{$team->id}}" data-team-name="{{$team->name}}" value="{{$team->id}}">{{$team->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="player2">Player</label>
                                                <select class="custom-select js-select2" id="player2" name="playerIn">
                                                    <option value="">Select player</option>
                                                    {{-- @foreach($players as $key => $player)
                                                        <option data-team-id="{{$player->team_id}}" data-team-name="{{$player->team_name}}" data-player-id="{{$player->player_id}}"  data-player-name="{{ $player->player_first_name.' '.$player->player_last_name}}" data-manager-name="{{ $player->manager_first_name.' '.$player->manager_last_name}}" value="{{$player->player_id}}">{{get_player_name('fullName', $player->player_first_name, $player->player_last_name)}} ({{$player->club_short_code}}) {{player_position_short($player->position)}} - {{$player->team_name}} </option>
                                                     @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="inSwapAmount">+ Cash (£m)</label>
                                                <input type="text" class="form-control" id="inSwapAmount" name="inSwapAmount" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover player-list-table" style="display: none">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Team 1</th>
                                                    <th>out</th>
                                                    <th>Team 2</th>
                                                    <th>out</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mb-2 gutters-md">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary btn-block" id="finishedBtn" disabled>PROCESS SWAPS</button>
                                        </div>
                                        <div class="col-6">
                                            {{-- <button type="submit" class="btn btn-primary btn-block actionBtn" id="addSwapBtn" data-type="add" disabled>Add swap</button> --}}
                                            <button type="submit" class="btn btn-primary btn-block actionBtn" id="addSwapBtn" data-type="add" disabled>Add swap</button>
                                            <button type="submit" class="btn btn-primary w-100 actionBtn" id="editSwapBtn" data-type="edit" style="display: none">Edit swap</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
