@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/divisions/edit.js') }}"></script>
<script src="{{ asset('js/admin/divisions/team-index.js') }}"></script>
<script src="{{ asset('js/admin/divisions/team-create.js') }}"></script>
<script src="{{ asset('js/admin/divisions/subdivison.js') }}"></script>
<script src="{{ asset('js/admin/divisions/points.js') }}"></script>
@endpush

@section('content')

<form class="js-division-edit-form" action="{{ route('admin.divisions.update', ['division' => $division]) }}" method="post">
    @csrf
    @method('PUT')
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Division</h3>
            <div class="block-options">
            </div>
        </div>
        <input type="hidden" value="{{$selectedLeagueType == "No" ? $defaultconsumerId : 0}}" id="social_id" name="social_id">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $division->name }}" placeholder="First name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="chairman_id form-group{{ $errors->has('chairman_id') ? ' is-invalid' : '' }}">
                        <label for="chairman_id" class="required">Chairman:</label>
                        <select class="form-control js-select2" id="chairman_id" name="chairman_id"  {{$selectedLeagueType == "No" ? 'disabled' :''}}>
                            <option value="" >Please select</option>
                            @foreach($consumers as $id => $consumer)
                                <option value="{{ $consumer->id }}" @if($consumer->id == $division->chairman_id) selected  @endif>{{ $consumer->first_name.' '.$consumer->last_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('chairman_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('chairman_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('package_id') ? ' is-invalid' : '' }}">
                        <label for="package_id">Subscription package:</label>
                        <select class="form-control js-select2" id="package_id" name="package_id">
                            @foreach($packages as $key => $package)
                                @if( $seasonAvailablePackages && in_array($key, $seasonAvailablePackages))
                                    <option data-default-id="{{$defaultconsumerId}}" data-default-name = "{{$defaultName}}" data-league-type={{ $leagueType[$package] }} value="{{ $key }}" @if($key == $division->package_id) selected  @endif>{{ $package }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('prize_pack') ? ' is-invalid' : '' }}">
                        <label for="prize_pack">Prize pack:</label>
                        <select class="form-control js-select2" id="prize_pack" name="prize_pack">
                            @foreach($allPrizePacks as $key => $value)
                                <option value="{{ $key }}" {{ $key == array_get($division,'prize_pack',[]) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="co_chairman_id">Co-chairmen:</label>
                        <select class="form-control" id="co_chairman_id" name="co_chairman_id[]" multiple="multiple"  {{$selectedLeagueType == "No" ? 'disabled' :''}}>
                            <option value="">Please select</option>
                            @foreach($coChairmens as $id => $consumer)
                                <option value="{{ $consumer->id }}" @if($division->coChairmen->pluck('id')->contains($consumer->id)) selected  @endif>{{ $consumer->first_name.' '.$consumer->last_name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('parent_division_id') ? ' is-invalid' : '' }}">
                        <label for="parent_division_id">Parent division (league):</label>
                        <select class="form-control" id="parent_division_id" name="parent_division_id" {{$selectedLeagueType == "No" ? 'disabled' :''}}>
                            <option value="">No parent division (stanalone league)</option>
                            @foreach($divisions as $id => $name)
                                <option value="{{ $id }}" @if($id == $division->parent_division_id) selected  @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('introduction') ? ' is-invalid' : '' }}">
                        <label for="introduction">Introduction:</label>
                        <textarea class="form-control" id="introduction" rows="3" name="introduction">{{$division->introduction }}</textarea>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="block">
        <input type="hidden" class="form-control" id="filter-division_id" name="division_id" value={{$division->id}}>
        <div class="block-header block-header-default">
            <h3 class="block-title"></h3>
            <div class="block-options">
               <select name="season" id="filter-season" class="form-control">
                    @foreach($seasons as $id => $season)
                        <option value="{{ $id }}">{{ $season }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Auction</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">


                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('auction_types') ? ' is-invalid' : '' }}">
                        <label for="auction_types">Auction types:</label>
                        <select class="form-control js-select2" id="auction_types" name="auction_types" {{$selectedLeagueType == "No" ? 'disabled' :''}}>
                            @foreach($auctionTypesEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->auction_types) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                   <label for="auction_date">Traditional auction date:</label>
                   <div class="input-group date">
                        <input type="text"
                            class="form-control"
                            id="auction_date"
                            name="auction_date"
                            placeholder="Package Default"
                            data-date-format="{{config('fantasy.datetimepicker.format')}}"
                            data-autoclose="true"
                            data-today-highlight="true"
                            autocomplete="off"
                            value="{{ carbon_format_to_time($division->auction_date) }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pre_season_auction_budget') ? ' is-invalid' : '' }}">
                        <label for="pre_season_auction_budget">Budget:</label>
                        <input type="text" class="form-control" id="pre_season_auction_budget" name="pre_season_auction_budget" value="{{$division->pre_season_auction_budget}}" placeholder="Package Default ({{$division->package->getOptionValue('pre_season_auction_budget')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pre_season_auction_bid_increment') ? ' is-invalid' : '' }}">
                        <label for="pre_season_auction_bid_increment">Bid Increment:</label>
                        <input type="text" class="form-control" id="pre_season_auction_bid_increment" name="pre_season_auction_bid_increment" value="{{$division->pre_season_auction_bid_increment}}" placeholder="Package Default ({{$division->package->getOptionValue('pre_season_auction_bid_increment')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('budget_rollover') ? ' is-invalid' : '' }}">
                        <label for="budget_rollover">Rollover budget:</label>
                        <select class="form-control js-select2" id="budget_rollover" name="budget_rollover">
                            <option value="">Package Default ({{$yesNo[$division->package->budget_rollover]}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" {{ $key == $division->budget_rollover ? 'selected':''}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Sealed Bids</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bids_budget') ? ' is-invalid' : '' }}">
                        <label for="seal_bids_budget">Budget:</label>
                        <input type="text" class="form-control" id="seal_bids_budget" name="seal_bids_budget" value="{{$division->seal_bids_budget}}" placeholder="Package Default ({{$division->package->getOptionValue('seal_bids_budget')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_increment') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_increment">Bid Increment:</label>
                        <input type="text" class="form-control" id="seal_bid_increment" name="seal_bid_increment" value="{{$division->seal_bid_increment}}" placeholder="Package Default ({{$division->package->getOptionValue('seal_bid_increment')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_minimum') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_minimum">Minimum bid:</label>
                        <input type="text" class="form-control" id="seal_bid_minimum" name="seal_bid_minimum" value="{{$division->seal_bid_minimum}}" placeholder="Package Default ({{$division->package->getOptionValue('seal_bid_minimum')}})">
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('manual_bid') ? ' is-invalid' : '' }}">
                        <label for="manual_bid">Automatically process:</label>
                        <select class="form-control js-select2" id="manual_bid" name="manual_bid">
                            <option value="">Package Default ({{$division->package->manual_bid}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->manual_bid) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                   <label for="first_seal_bid_deadliness">First round deadline:</label>
                   <div class="input-group date">
                        <input type="text"
                            class="form-control"
                            id="first_seal_bid_deadliness"
                            name="first_seal_bid_deadline"
                            placeholder="Package Default"
                            data-date-format="{{config('fantasy.datetimepicker.format')}}"
                            data-autoclose="true"
                            data-today-highlight="true"
                            autocomplete="off"
                            value="{{ carbon_format_to_time($division->first_seal_bid_deadline) }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_deadline_repeat') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_deadline_repeat">Round deadline repeat:</label>
                        <select class="form-control js-select2" id="seal_bid_deadline_repeat" name="seal_bid_deadline_repeat">
                            <option value="">Package Default ({{$sealedBidDeadLinesEnum[$division->package->seal_bid_deadline_repeat]}})</option>
                            @foreach($sealedBidDeadLinesEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->seal_bid_deadline_repeat) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('max_seal_bids_per_team_per_round') ? ' is-invalid' : '' }}">
                        <label for="max_seal_bids_per_team_per_round">Max bids per round:</label>
                        <input type="text" class="form-control" id="max_seal_bids_per_team_per_round" name="max_seal_bids_per_team_per_round" value="{{$division->max_seal_bids_per_team_per_round}}" placeholder="Package Default ({{$division->package->getOptionValue('max_seal_bids_per_team_per_round')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('money_back') ? ' is-invalid' : '' }}">
                        <label for="money_back">Money Back:</label>
                        <select class="form-control js-select2" id="money_back" name="money_back">
                            <option value="">Package Default ({{$division->getOptionValue('money_back') ? $moneyBackEnum[$division->getOptionValue('money_back')] : ''}})</option>
                            @foreach($division->package->money_back_types as $key => $value)
                                <option value="{{ $value }}" @if($value == $division->getOptionValue('money_back')) selected  @endif>{{$moneyBackEnum[$value]}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('tie_preference') ? ' is-invalid' : '' }}">
                        <label for="tie_preference">Tie preference:</label>
                        <select class="form-control js-select2" id="tie_preference" name="tie_preference">
                            <option value="">Package Default ({{$tiePreferenceEnum[$division->package->tie_preference]}})</option>
                            @foreach($tiePreferenceEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->tie_preference) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('rules') ? ' is-invalid' : '' }}">
                        <label for="rules">Rules:</label>
                        <textarea class="form-control" id="rules" rows="3" name="rules">{{$division->rules }}</textarea>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Squad and formations</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('custom_squad_size') ? ' is-invalid' : '' }}">
                        <label for="custom_squad_size">Squad size:</label>
                        <input type="text" class="form-control" id="default_squad_size" name="default_squad_size" value="{{$division->default_squad_size}}" placeholder="Package Default ({{$division->package->getOptionValue('default_squad_size')}})" {{ ( $division->package->custom_squad_size == $onlyNoEnum ) ? 'readonly' : '' }}>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('custom_club_quota') ? ' is-invalid' : '' }}">
                        <label for="custom_club_quota">Club quota:</label>
                         <input type="text" class="form-control" id="default_max_player_each_club" name="default_max_player_each_club" value="{{$division->default_max_player_each_club}}" placeholder="Package Default ({{$division->package->getOptionValue('default_max_player_each_club')}}) "{{ ( $division->package->custom_club_quota == $onlyNoEnum ) ? 'readonly' : '' }}>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="dob">Allowed formations:</label>
                        <div class="row no-gutters items-push">
                            @foreach($formation as $key => $value)
                                <label class="css-control css-control-primary css-checkbox">
                                    <input type="checkbox" class="css-control-input" value="{{$key}}" id="available_formations-{{$key}}" name="available_formations[]" @if((($division->available_formations) && in_array($key, $division->available_formations)) || ($division->available_formations == null)) checked @endif>
                                    <span class="css-control-indicator"></span> {{$value}}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('defensive_midfields') ? ' is-invalid' : '' }}">
                        <label for="defensive_midfields">Defensive midfields:</label>
                        <select class="form-control js-select2" id="defensive_midfields" name="defensive_midfields">
                            <option value="">Package Default ({{$yesNo[$division->package->defensive_midfields]}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->defensive_midfields) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('merge_defenders') ? ' is-invalid' : '' }}">
                        <label for="merge_defenders">Merge defenders:</label>
                        <select class="form-control js-select2" id="merge_defenders" name="merge_defenders">
                            <option value="">Package Default ({{$yesNo[$division->package->merge_defenders]}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->merge_defenders) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_weekend_changes') ? ' is-invalid' : '' }}">
                        <label for="allow_weekend_changes">Allow weekend changes:</label>
                        <select class="form-control js-select2" id="allow_weekend_changes" name="allow_weekend_changes">
                            <option value="">Package Default ({{$yesNo[$division->package->allow_weekend_changes]}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->allow_weekend_changes) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Transfers</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('enable_free_agent_transfer') ? ' is-invalid' : '' }}">
                        <label for="enable_free_agent_transfer">Allow transfer:</label>
                        <select class="form-control js-select2" id="enable_free_agent_transfer" name="enable_free_agent_transfer">
                            <option value="">Package Default ({{$yesNo[$division->package->enable_free_agent_transfer]}})</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->enable_free_agent_transfer) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('free_agent_transfer_authority') ? ' is-invalid' : '' }}">
                        <label for="free_agent_transfer_authority">Transfer authority:</label>
                        <select class="form-control js-select2" id="free_agent_transfer_authority" name="free_agent_transfer_authority">
                            <option value="">Package Default ({{$transferAuthority[$division->package->free_agent_transfer_authority]}})</option>
                            @foreach($transferAuthority as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->free_agent_transfer_authority) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('free_agent_transfer_after') ? ' is-invalid' : '' }}">
                        <label for="free_agent_transfer_after">Transfer start date:</label>
                        <select class="form-control js-select2" id="free_agent_transfer_after" name="free_agent_transfer_after">
                            <option value="">Package Default ({{$agentTransferAfterEnum[$division->package->free_agent_transfer_after]}})</option>
                            @foreach($agentTransferAfterEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $division->free_agent_transfer_after) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('season_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="season_free_agent_transfer_limit">Season Transfer quota:</label>
                        <input type="text" class="form-control" id="season_free_agent_transfer_limit" name="season_free_agent_transfer_limit" value="{{$division->season_free_agent_transfer_limit}}" placeholder="Package Default  ({{$division->package->getOptionValue('season_free_agent_transfer_limit')}})">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('monthly_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="monthly_free_agent_transfer_limit">Monthly Transfer quota:</label>
                        <input type="text" class="form-control" id="monthly_free_agent_transfer_limit" name="monthly_free_agent_transfer_limit" value="{{$division->monthly_free_agent_transfer_limit}}" placeholder="Package Default  ({{$division->package->getOptionValue('monthly_free_agent_transfer_limit')}})">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Europa competition</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="europa_league_team_1">Europa league team1:</label>
                        <select class="form-control js-select2" id="europa_league_team_1" name="europa_league_team_1" @if($isCompetetionStarted) disabled  @endif>
                            <option value="">Select team</option>
                            @foreach($teams as $key => $team)
                                    <option value="{{ $key }}" @if($key == $division->europa_league_team_1) selected  @endif>{{ $team }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="europa_league_team_1">Europa league team2:</label>
                        <select class="form-control js-select2" id="europa_league_team_2" name="europa_league_team_2" @if($isCompetetionStarted) disabled  @endif>
                            <option value="">Select team</option>
                            @foreach($teams as $key => $team)
                                    <option value="{{ $key }}" @if($key == $division->europa_league_team_2) selected  @endif>{{ $team }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="champions_league_team">Champions league team:</label>
                        <select class="form-control js-select2" id="champions_league_team" name="champions_league_team" @if($isCompetetionStarted) disabled  @endif>
                            <option value="">Select team</option>
                            @foreach($teams as $key => $team)
                                    <option value="{{ $key }}" @if($key == $division->champions_league_team) selected  @endif>{{ $team }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Points</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
           <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Event/Position</th>
                        @foreach($positionsEnum as $key => $value)
                        <th>{{$value}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventsEnum as $event_key => $event_value)
                        <tr>
                            <th>{{$event_value}}</th>
                            @foreach($positionsEnum as $position_key => $position_value)
                            <td>
                                 <div class='mb-0 form-group{{ $errors->has("points.$event_key.$position_key") ? " is-invalid" : "" }}'>
                                    <input type="text" class="form-control events-points" name="points[{{$event_key}}][{{$position_key}}]" value="{{isset($division->divisionPoints[$loop->parent->index][$position_key]) ? $division->divisionPoints[$loop->parent->index][$position_key] : ''}}" placeholder="Default({{$division->package->getOptionValue($position_key,$event_key)}})" {{ ( $division->package->allow_custom_scoring == $onlyNoEnum ) ? 'readonly' : '' }}>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
           </div>
        </div>

    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update Division</button>
         <button id = "recalculate-points" type="button"  data-url="{{route('admin.divisions.points.recalculate', ['division' => $division])}}" class="btn btn-hero btn-noborder btn-primary">Recalculate Points</button>
        <a href="{{ route('admin.divisions.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>

{{-- Include Dvisivion/Team listing file --}}
    @include('admin.divisions.team.index')

    @if($division->divisons->count())
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Division List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter table-hover admin-sub-divisions-list-table" data-url="{{ route('admin.divisions.subdivison.data') }}"></table>
            </div>
        </div>
    @endif
@stop


@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
<div class="modal fade" id="modal_create_team_box" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Add New Team</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times-circle"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form class="js-team-create-form" action="{{ route('admin.division.team.storeTeam') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                    <label for="name" class="required">Team name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Team name">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group{{ $errors->has('manager_id') ? ' is-invalid' : '' }}">
                                    <label for="manager_id" class="required">Manager:</label>
                                    <select class="form-control" id="manager_id" name="manager_id" style="width: 100%">
                                        <option value="">Please select</option>
                                        @foreach($consumers as $key => $manager)
                                            <option value="{{$manager->id}}">{{$manager->first_name . ' ' . $manager->last_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('manager_id'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('manager_id') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group{{ $errors->has('division_id') ? ' is-invalid' : '' }}">
                                    <label for="division_id" class="required">Division:</label>
                                    <select class="form-control js-select2" id="division_id" name="division_id" style="width: 100%">
                                        <option value="">Please select</option>
                                        @foreach($allDivisions as $id => $name)
                                            <option value="{{$id}}" {{ $division->id == $id ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('division_id'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('division_id') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group{{ $errors->has('pitch_id') ? ' is-invalid' : '' }}">
                                    <label for="pitch_id">Pitch:</label>
                                    <select class="form-control js-select2" id="pitch_id" name="pitch_id" style="width: 100%">
                                        <option value="">Please select</option>
                                        @foreach($pitches as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pitch_id'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('pitch_id') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group{{ $errors->has('crest_id') ? ' is-invalid' : '' }}">
                                    <label for="crest_id" class="required">Badge:</label>
                                    <select class="form-control" id="crest_id" name="crest_id" style="width: 100%">
                                        <option value="">Please select</option>
                                        @foreach($crests as $key => $crest)
                                            <option data-img="{{$crest->getMedia('crest')->last() ? $crest->getMedia('crest')->last()->getUrl('thumb') : ''}}" value="{{$crest->id}}">{{$crest->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('crest_id'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('crest_id') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                                    <label for="photo">User Badge:</label>
                                    <input type="file" name="crest" id="crest">
                                    <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                                    @if ($errors->has('crest'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('crest') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="create-new-team-button" class="btn btn-hero btn-noborder btn-default" data-form="#js-divison-team-new-create-form">Create Team</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endpush
