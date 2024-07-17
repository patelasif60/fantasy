@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/packages/edit.js') }}"></script>
@endpush

@section('content')

<form class="js-package-edit-form" action="{{ route('admin.packages.update', ['package' => $package]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Package</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Package name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Package name" value="{{ $package->name }}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('display_name') ? ' is-invalid' : '' }}">
                        <label for="display_name">Display name:</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display name" value="{{ $package->display_name }}">

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('is_enabled') ? ' is-invalid' : '' }}">
                        <label for="is_enabled">Enabled:</label>
                        <select class="form-control js-select2" id="is_enabled" name="is_enabled">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->is_enabled) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('available_new_user') ? ' is-invalid' : '' }}">
                        <label for="available_new_user">Available for new users only:</label>
                        <select class="form-control js-select2" id="available_new_user" name="available_new_user">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->available_new_user) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="auction_budget" class="required">Price:</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">&pound;</div>
                            </div>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ $package->price }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('private_league') ? ' is-invalid' : '' }}">
                        <label for="private_league">Private league:</label>
                        <select class="form-control js-select2" id="private_league" name="private_league">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->private_league) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('minimum_teams') ? ' is-invalid' : '' }}">
                        <label for="minimum_teams" class="required">Minimum teams:</label>
                        <input type="text" class="form-control" id="minimum_teams" name="minimum_teams" placeholder="Minimum teams" value="{{ $package->minimum_teams }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('maximum_teams') ? ' is-invalid' : '' }}">
                        <label for="maximum_teams" class="required">Maximum teams:</label>
                        <input type="text" class="form-control" id="maximum_teams" name="maximum_teams" placeholder="Maximum teams" value="{{ $package->maximum_teams }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('short_description') ? ' is-invalid' : '' }}">
                        <label for="short_description">Short description:</label>
                        <textarea class="form-control" id="short_description" rows="3" name="short_description">{{ $package->short_description }}</textarea>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('long_description') ? ' is-invalid' : '' }}">
                        <label for="long_description">Long description:</label>
                        <textarea class="form-control" id="long_description" rows="3" name="long_description">{{ $package->long_description }}</textarea>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('prize_packs') ? ' is-invalid' : '' }}">
                        <label for="prize_packs">Prize packs:</label>
                        <select class="form-control js-select2" id="prize_packs" name="prize_packs[]" multiple="multiple">
                            @foreach($allPrizePacks as $key => $value)
                                <option value="{{ $key }}" {{ in_array($key, array_get($package,'prize_packs',[])) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('default_prize_pack') ? ' is-invalid' : '' }}">
                        <label for="default_prize_pack" class="required">Default prize pack:</label>
                        <select name="default_prize_pack" id="default_prize_pack" class="form-control js-select2">
                            <option value="">Select Prize Pack</option>
                            @foreach($allPrizePacks as $key => $value)
                                @if( in_array($key, array_get($package,'prize_packs',[])))
                                    <option value="{{ $key }}" @if($key == $package->default_prize_pack) selected ="selected" @endif>{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('max_free_places') ? ' is-invalid' : '' }}">
                        <label for="max_free_places" class="required">Max free places:</label>
                        <input type="text" class="form-control" id="max_free_places" name="max_free_places" placeholder="Max free places" value="{{ $package->max_free_places }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('free_placce_for_new_user') ? ' is-invalid' : '' }}">
                        <label for="enable_supersubs">Free place for new user:</label>
                        <select class="form-control js-select2" id="free_placce_for_new_user" name="free_placce_for_new_user">
                                <option value=''>Please select</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}"  @if($key == $package->free_placce_for_new_user) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('enable_supersubs') ? ' is-invalid' : '' }}">
                        <label for="enable_supersubs">Enable Supersubs:</label>
                        <select class="form-control js-select2" id="enable_supersubs" name="enable_supersubs">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->enable_supersubs) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('badge_color') ? ' is-invalid' : '' }}">
                        <label for="badge_color">Badge Color:</label>
                        <select class="form-control js-select2" id="badge_color" name="badge_color">
                            @foreach($badgeColors as $key => $value)
                                <option value="{{ $key }}" {{ $key == $package->badge_color ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                        <label for="auction_types" class="required">Auction types:</label>
                        <select class="form-control js-select2" id="auction_types" name="auction_types[]" multiple="multiple">
                            @foreach($auctionTypesEnum as $key => $value)
                                <option value="{{ $key }}" @if( in_array($key, array_get($package,'auction_types',[]))) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pre_season_auction_budget') ? ' is-invalid' : '' }}">
                        <label for="pre_season_auction_budget" class="required">Budget:</label>
                        <input type="text" class="form-control" id="pre_season_auction_budget" name="pre_season_auction_budget" value="{{$package->pre_season_auction_budget}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pre_season_auction_bid_increment') ? ' is-invalid' : '' }}">
                        <label for="pre_season_auction_bid_increment" class="required">Bid increment:</label>
                        <input type="text" class="form-control" id="pre_season_auction_bid_increment" name="pre_season_auction_bid_increment" value="{{$package->pre_season_auction_bid_increment}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('budget_rollover') ? ' is-invalid' : '' }}">
                        <label for="budget_rollover">Rollover budget:</label>
                        <select class="form-control js-select2" id="budget_rollover" name="budget_rollover">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->budget_rollover) selected  @endif>{{$value}}</option>
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
                        <label for="seal_bids_budget" class="required">Budget:</label>
                        <input type="text" class="form-control" id="seal_bids_budget" name="seal_bids_budget" value="{{$package->seal_bids_budget}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_increment') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_increment" class="required">Bid increment:</label>
                        <input type="text" class="form-control" id="seal_bid_increment" name="seal_bid_increment" value="{{$package->seal_bid_increment}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_minimum') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_minimum" class="required">Bid minimum:</label>
                        <input type="text" class="form-control" id="seal_bid_minimum" name="seal_bid_minimum" value="{{$package->seal_bid_minimum}}">
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('manual_bid') ? ' is-invalid' : '' }}">
                        <label for="manual_bid">Automatically process:</label>
                        <select class="form-control js-select2" id="manual_bid" name="manual_bid">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->manual_bid) selected  @endif>{{$value}}</option>
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
                            placeholder="Date"
                            data-date-format="{{config('fantasy.datetimepicker.format')}}"
                            data-autoclose="true"
                            data-today-highlight="true"
                            autocomplete="off"
                            value="{{ carbon_format_to_time($package->first_seal_bid_deadline) }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('seal_bid_deadline_repeat') ? ' is-invalid' : '' }}">
                        <label for="seal_bid_deadline_repeat">Round deadline repeat:</label>
                        <select class="form-control js-select2" id="seal_bid_deadline_repeat" name="seal_bid_deadline_repeat">
                            @foreach($sealedBidDeadLinesEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->seal_bid_deadline_repeat) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('max_seal_bids_per_team_per_round') ? ' is-invalid' : '' }}">
                        <label for="max_seal_bids_per_team_per_round" class="required">Max bids per round:</label>
                        <input type="text" class="form-control" id="max_seal_bids_per_team_per_round" name="max_seal_bids_per_team_per_round" value="{{$package->max_seal_bids_per_team_per_round}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('tie_preference') ? ' is-invalid' : '' }}">
                        <label for="tie_preference">Tie preference:</label>
                        <select class="form-control js-select2" id="tie_preference" name="tie_preference">
                            @foreach($tiePreferenceEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->tie_preference) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_season_budget') ? ' is-invalid' : '' }}">
                        <label for="enable_supersubs">Allow season budget:</label>
                        <select class="form-control js-select2" id="allow_season_budget" name="allow_season_budget">
                            <option value=''>Please select</option>
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_season_budget) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Teams</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">


                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('custom_squad_size') ? ' is-invalid' : '' }}">
                        <label for="custom_squad_size">Allow customisable squad size:</label>
                        <select class="form-control js-select2" id="custom_squad_size" name="custom_squad_size">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->custom_squad_size) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('default_squad_size') ? ' is-invalid' : '' }}">
                        <label for="default_squad_size" class="required">Squad size:</label>
                        <input type="text" class="form-control" id="default_squad_size" name="default_squad_size" value="{{$package->default_squad_size}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('custom_club_quota') ? ' is-invalid' : '' }}">
                        <label for="custom_club_quota">Allow customisable club quota:</label>
                        <select class="form-control js-select2" id="custom_club_quota" name="custom_club_quota">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->custom_club_quota) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                               <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('default_max_player_each_club') ? ' is-invalid' : '' }}">
                        <label for="default_max_player_each_club" class="required">Club quota:</label>
                        <input type="text" class="form-control" id="default_max_player_each_club" name="default_max_player_each_club" value="{{$package->default_max_player_each_club}}">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Formation</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('defensive_midfields') ? ' is-invalid' : '' }}">
                        <label for="defensive_midfields">Defensive midfields:</label>
                        <select class="form-control js-select2" id="defensive_midfields" name="defensive_midfields">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->defensive_midfields) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('merge_defenders') ? ' is-invalid' : '' }}">
                        <label for="merge_defenders">Merge defenders:</label>
                        <select class="form-control js-select2" id="merge_defenders" name="merge_defenders">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->merge_defenders) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="dob">Allowed formations:</label>
                        <div class="row no-gutters items-push">
                            @foreach($formation as $key => $value)
                                <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input formation-group" value="{{$key}}" id="available_formations-{{$key}}" name="available_formations[]" @if(($package->available_formations) && in_array($key, $package->available_formations)) checked @endif>
                                <span class="css-control-indicator"></span> {{$value}}
                            </label>
                            @endforeach
                        </div>
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
                        <label for="enable_free_agent_transfer">Enable transfer:</label>
                        <select class="form-control js-select2" id="enable_free_agent_transfer" name="enable_free_agent_transfer">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->enable_free_agent_transfer) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('free_agent_transfer_authority') ? ' is-invalid' : '' }}">
                        <label for="free_agent_transfer_authority">Transfer authority:</label>
                        <select class="form-control js-select2" id="free_agent_transfer_authority" name="free_agent_transfer_authority">
                            @foreach($transferAuthority as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->free_agent_transfer_authority) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('free_agent_transfer_after') ? ' is-invalid' : '' }}">
                        <label for="free_agent_transfer_after">Transfer after:</label>
                        <select class="form-control js-select2" id="free_agent_transfer_after" name="free_agent_transfer_after">
                            @foreach($agentTransferAfterEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->free_agent_transfer_after) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('season_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="season_free_agent_transfer_limit" class="required">Season transfer limit:</label>
                        <input type="text" class="form-control" id="season_free_agent_transfer_limit" name="season_free_agent_transfer_limit" value="{{$package->season_free_agent_transfer_limit}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('monthly_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="monthly_free_agent_transfer_limit" class="required">Monthly transfer limit:</label>
                        <input type="text" class="form-control" id="monthly_free_agent_transfer_limit" name="monthly_free_agent_transfer_limit" value="{{$package->monthly_free_agent_transfer_limit}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_weekend_changes') ? ' is-invalid' : '' }}">
                        <label for="allow_weekend_changes">Allow weekend changes:</label>
                        <select class="form-control js-select2" id="allow_weekend_changes" name="allow_weekend_changes">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_weekend_changes) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Extra Competitions</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_custom_cup') ? ' is-invalid' : '' }}">
                        <label for="allow_custom_cup">Allow custom cups:</label>
                        <select class="form-control js-select2" id="allow_custom_cup" name="allow_custom_cup">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_custom_cup) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_fa_cup') ? ' is-invalid' : '' }}">
                        <label for="allow_fa_cup">Allow FA Cup:</label>
                        <select class="form-control js-select2" id="allow_fa_cup" name="allow_fa_cup">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_fa_cup) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_champion_league') ? ' is-invalid' : '' }}">
                        <label for="allow_champion_league">Allow Champions League:</label>
                        <select class="form-control js-select2" id="allow_champion_league" name="allow_champion_league">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_champion_league) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_europa_league') ? ' is-invalid' : '' }}">
                        <label for="allow_europa_league">Allow Europa League:</label>
                        <select class="form-control js-select2" id="allow_europa_league" name="allow_europa_league">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_europa_league) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_head_to_head') ? ' is-invalid' : '' }}">
                        <label for="allow_head_to_head">Allow head to head:</label>
                        <select class="form-control js-select2" id="allow_head_to_head" name="allow_head_to_head">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_head_to_head) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_linked_league') ? ' is-invalid' : '' }}">
                        <label for="allow_linked_league">Allow linked leagues:</label>
                        <select class="form-control js-select2" id="allow_linked_league" name="allow_linked_league">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_linked_league) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_process_bids') ? ' is-invalid' : '' }}">
                        <label for="allow_process_bids">Allow process bids:</label>
                        <select class="form-control js-select2" id="allow_process_bids" name="allow_process_bids">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}"@if($key == $package->allow_process_bids) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_auction_budget') ? ' is-invalid' : '' }}">
                        <label for="allow_auction_budget">Allow auction budget:</label>
                        <select class="form-control js-select2" id="allow_auction_budget" name="allow_auction_budget">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}"@if($key == $package->allow_auction_budget) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_bid_increment') ? ' is-invalid' : '' }}">
                        <label for="allow_bid_increment">Allow bid increment:</label>
                        <select class="form-control js-select2" id="allow_bid_increment" name="allow_bid_increment">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}"@if($key == $package->allow_bid_increment) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_defensive_midfielders') ? ' is-invalid' : '' }}">
                        <label for="allow_defensive_midfielders">Allow defensive midfielders :</label>
                        <select class="form-control js-select2" id="allow_defensive_midfielders" name="allow_defensive_midfielders">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_defensive_midfielders) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_merge_defenders') ? ' is-invalid' : '' }}">
                        <label for="allow_merge_defenders">Allow merge defenders :</label>
                        <select class="form-control js-select2" id="allow_merge_defenders" name="allow_merge_defenders">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_merge_defenders) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_weekend_changes_editable') ? ' is-invalid' : '' }}">
                        <label for="allow_weekend_changes_editable">Allow allow weekend changes editable :</label>
                        <select class="form-control js-select2" id="allow_weekend_changes_editable" name="allow_weekend_changes_editable">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_weekend_changes_editable) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_rollover_budget') ? ' is-invalid' : '' }}">
                        <label for="allow_rollover_budget">Allow rollover budget:</label>
                        <select class="form-control js-select2" id="allow_rollover_budget" name="allow_rollover_budget">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_rollover_budget) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_available_formations') ? ' is-invalid' : '' }}">
                        <label for="allow_available_formations">Allow available formations:</label>
                        <select class="form-control js-select2" id="allow_available_formations" name="allow_available_formations">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_available_formations) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_supersubs') ? ' is-invalid' : '' }}">
                        <label for="allow_supersubs">Allow supersubs:</label>
                        <select class="form-control js-select2" id="allow_supersubs" name="allow_supersubs">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_supersubs) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_seal_bid_deadline_repeat') ? ' is-invalid' : '' }}">
                        <label for="allow_seal_bid_deadline_repeat">Allow seal bid deadline repeat:</label>
                        <select class="form-control js-select2" id="allow_seal_bid_deadline_repeat" name="allow_seal_bid_deadline_repeat">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_seal_bid_deadline_repeat) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_season_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="allow_season_free_agent_transfer_limit">Allow season free agent transfer limit:</label>
                        <select class="form-control js-select2" id="allow_season_free_agent_transfer_limit" name="allow_season_free_agent_transfer_limit">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_season_free_agent_transfer_limit) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_monthly_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
                        <label for="allow_monthly_free_agent_transfer_limit">Allow monthly free agent transfer limit :</label>
                        <select class="form-control js-select2" id="allow_monthly_free_agent_transfer_limit" name="allow_monthly_free_agent_transfer_limit">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_monthly_free_agent_transfer_limit) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_free_agent_transfer_authority') ? ' is-invalid' : '' }}">
                        <label for="allow_free_agent_transfer_authority">Allow free agent transfer authority :</label>
                        <select class="form-control js-select2" id="allow_free_agent_transfer_authority" name="allow_free_agent_transfer_authority">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_free_agent_transfer_authority) selected  @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_enable_free_agent_transfer ') ? ' is-invalid' : '' }}">
                        <label for="allow_enable_free_agent_transfer">Allow enable free agent transfer :</label>
                        <select class="form-control js-select2" id="allow_enable_free_agent_transfer" name="allow_enable_free_agent_transfer">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_enable_free_agent_transfer) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_free_agent_transfer_after') ? ' is-invalid' : '' }}">
                        <label for="allow_free_agent_transfer_after">Allow free agent transfer after :</label>
                        <select class="form-control js-select2" id="allow_free_agent_transfer_after" name="allow_free_agent_transfer_after">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_free_agent_transfer_after) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_seal_bid_minimum') ? ' is-invalid' : '' }}">
                        <label for="allow_seal_bid_minimum">Allow seal bid minimum :</label>
                        <select class="form-control js-select2" id="allow_seal_bid_minimum" name="allow_seal_bid_minimum">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_seal_bid_minimum) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_tie_preference') ? ' is-invalid' : '' }}">
                        <label for="allow_free_agent_transfer_authority">Allow tie preference :</label>
                        <select class="form-control js-select2" id="allow_tie_preference" name="allow_tie_preference">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_tie_preference) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_money_back') ? ' is-invalid' : '' }}">
                        <label for="allow_money_back">Allow money back types:</label>
                        <select class="form-control js-select2" id="allow_money_back" name="allow_money_back">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_money_back) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('allow_max_bids_per_round') ? ' is-invalid' : '' }}">
                        <label for="allow_max_bids_per_round">Allow max bids per round:</label>
                        <select class="form-control js-select2" id="allow_max_bids_per_round" name="allow_max_bids_per_round">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->allow_max_bids_per_round) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="form-group">
                        <label for="dob">Allowed money backs:</label>
                        <div class="row no-gutters items-push">
                            @foreach($moneyBackEnum as $key => $value)
                                <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input money-back-group" value="{{$key}}" id="money_back_types-{{$key}}" name="money_back_types[]" @if(($package->money_back_types) && in_array($key, $package->money_back_types)) checked @endif>
                                <span class="css-control-indicator"></span> {{$value}}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Digital Prizes</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('digital_prize_type') ? ' is-invalid' : '' }}">
                        <label for="digital_prize_type">Digital prize type:</label>
                        <select class="form-control js-select2" id="digital_prize_type" name="digital_prize_type">
                            @foreach($digitalPrizeTypeEnum as $key => $value)
                                <option value="{{ $key }}" @if($key == $package->digital_prize_type) selected  @endif>{{$value}}</option>
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
                <div class="col-xl-6">
                    <label for="is_enabled">Allow custom scoring:</label>
                    <select class="form-control js-select2" id="allow_custom_scoring" name="allow_custom_scoring">
                        @foreach($yesNo as $key => $value)
                            <option value="{{ $key }}" @if($key == $package->allow_custom_scoring) selected  @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
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
                                <div class='parentDiv mb-0 form-group{{ $errors->has("points.$event_key.$position_key") ? " is-invalid" : "" }}'>
                                    @if($event_key == 'goal')
                                        <input type="text" class="form-control events-points positivePoint" name="points[{{$event_key}}][{{$position_key}}]" value="{{isset($package->packagePoints[$loop->parent->index][$position_key]) ? $package->packagePoints[$loop->parent->index][$position_key] : ''}}">

                                    @elseif($event_key == 'red_card' || $event_key == 'yellow_card' || $event_key == 'own_goal' || $event_key == 'penalty_missed' || $event_key == 'goal_conceded')

                                        <input type="text" class="form-control events-points negativePoint" name="points[{{$event_key}}][{{$position_key}}]" value="{{isset($package->packagePoints[$loop->parent->index][$position_key]) ? $package->packagePoints[$loop->parent->index][$position_key] : ''}}">

                                    @else

                                        <input type="text" class="form-control events-points" name="points[{{$event_key}}][{{$position_key}}]" value="{{isset($package->packagePoints[$loop->parent->index][$position_key]) ? $package->packagePoints[$loop->parent->index][$position_key] : ''}}">
                                    @endif


                                    <div class="warningMessage text-warning" style="display: none"></div>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update package</button>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
