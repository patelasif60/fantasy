@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/settings/auction.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li></li>
                <li class="text-center">Auction Settings</li>
                <li> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button> </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
        @include('manager.divisions.preauction.links', ['division' => $division])
    </div>
</div>
<form action="{{ route('manage.division.auction.store',['division' => $division ]) }}" encytype= "multipart/form-data" method="POST" class="js-division-update-form">
@csrf
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
        <div class="container-wrappper">
            <div class="container-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="custom-alert alert-tertiary">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                                <p class="mb-0">This is where you can set up all the details for your auction.</br class="d-none d-xl-inline-block">Please email <a href="mailto:auctionsupport@fantasyleague.com" >auctionsupport@fantasyleague.com</a> if you need any help with this.</p>
                            </div>
                        </div>
                    </div>

					<div class="col-12 text-white">
                        <div class="form-group {{ $errors->has('auction_types') ? ' is-invalid' : '' }}">
                                <label for="auction_types" class="required">Auction type:</label>
                                <select {{$disable}} class="custom-select js-select2 auction-types-js" id="auction_types" name="auction_types">
                                    @foreach($auctionTypesEnum as $key => $value)
                                        @if (in_array($key,$division->package->auction_types))
                                            <option value="{{ $key }}" @if($key == $division->getOptionValue('auction_types')) selected  @endif>{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('auction_types'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('auction_types') }}</strong>
                                    </div>
                                @endif
                            </div>
							<input type="hidden" value="{{count($division->auctionRounds)}}" id="js-round">
							<div class="row">
                                <div class="col-6 form-group{{ $errors->has('auction_date') ? ' is-invalid' : '' }}">
                                    <label for="auction_date" id="auction_date_label">Auction {{ trim($division->getOptionValue('auction_types'))=='Online sealed bids'?'start':''}} date</label>
                                    <input {{$disable}} type="text"
                                        class="form-control js-datetimepicker {{$division->getOptionValue('auction_types') == 'Online sealed bids' ? 'js-schedule-round' : ' ' }}"
                                        id="auction_date"
                                        name="auction_date"
                                        placeholder=""
                                        data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                        data-autoclose="true"
                                        data-today-highlight="true"
                                        autocomplete="off"
                                        value="{{$division->auction_date?carbon_format_to_time($auctionDate):''}}">
                                    @if ($errors->has('auction_date'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('auction_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-6 form-group{{ $errors->has('auction_time') ? ' is-invalid' : '' }}">
                                    <label for="auction_date" id="auction_date_label">Auction {{ trim($division->getOptionValue('auction_types'))=='Online sealed bids'?'start':''}} Time</label>
                                    <input {{$disable}} type="text"
                                        class="form-control time js-timepicker"
                                        id="auction_time"
                                        name="auction_time"
                                        placeholder=""
                                        value="{{$auctionTime}}">
                                    @if ($errors->has('auction_date'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('auction_time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="auction-venue-js">
                                <div class="form-group{{ $errors->has('auction_venue') ? ' is-invalid' : '' }}">
                                    <label for="auction_venue">Auction venue</label>
                                    <input {{ trim($division->getOptionValue('auction_types'))=='Online sealed bids'?'disabled':''}} {{$disable}} type="text" class="form-control" id="auction_venue" name="auction_venue" value="{{ $division->auction_venue }}">
                                    @if ($errors->has('auction_venue'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('auction_venue') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('pre_season_auction_budget') ? ' is-invalid' : '' }}">
                                        <label for="pre_season_auction_budget">Auction budget</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">&pound;</span>
                                          </div>
                                          <input type="text" {{ $division->package->allow_auction_budget == 'No' ?'disabled':''}} {{$disable}} class="form-control" id="pre_season_auction_budget" name="pre_season_auction_budget" value="{{ $division->getOptionValue('pre_season_auction_budget') }}">
                                          <div class="input-group-append">
                                            <span class="input-group-text">m</span>
                                          </div>
                                        </div>
                                        @if ($errors->has('pre_season_auction_budget'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('pre_season_auction_budget') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('pre_season_auction_bid_increment') ? ' is-invalid' : '' }}">
                                        <label for="pre_season_auction_bid_increment">Bid increment</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">&pound;</span>
                                          </div>
                                          <input type="text" class="form-control" id="pre_season_auction_bid_increment" name="pre_season_auction_bid_increment" value="{{ floatval($division->getOptionValue('pre_season_auction_bid_increment')) }}" {{ $division->package->allow_bid_increment == 'No' ?'disabled':''}} {{ $disable }}>
                                          <div class="input-group-append">
                                            <span class="input-group-text">m</span>
                                          </div>
                                        </div>

                                        @if ($errors->has('pre_season_auction_bid_increment'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('pre_season_auction_bid_increment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('budget_rollover') ? ' is-invalid' : '' }}">
                                <label for="budget_rollover" class="required">Add remaining budget from the auction to season budget </label>
                                <div class="custom-control custom-switch">
                                    <input  {{$division->package->allow_rollover_budget == 'No' ? 'disabled': '' }} type="checkbox" class="custom-control-input" id="budget_rollover" name="budget_rollover" {{ $division->getOptionValue('budget_rollover') == $yesNo['Yes'] ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="budget_rollover"></label>
                                </div>
                                @if ($errors->has('budget_rollover'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('budget_rollover') }}</strong>
                                    </div>
                                @endif
                            </div>
							<div class="live-online-auction-js">
                            	<div class="form-group {{ $errors->has('auctioneer') ? ' is-invalid' : '' }}">
                                    <label for="auctioneer" class="required">Auctioneer:</label>
                                    <select {{$disable}} class="custom-select js-select2" id="auctioneer" name="auctioneer">
                                        <option value="">Please select</option>
                                        @foreach($auctioneerData as  $auctioneer)
                                        	<option value="{{$auctioneer['id']}}" {{ $division->auctioneer_id == $auctioneer['id'] ? 'selected' :' '}}>{{$auctioneer['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('auctioneer'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('auctioneer') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('allow_passing_on_nominations') ? ' is-invalid' : '' }}">
                                    <label for="allow_passing_on_nominations" class="required">Allow passing on nominations? </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input allow-passing-on-nominations-js" id="allow_passing_on_nominations" name="allow_passing_on_nominations" @if($division->getOptionValue('allow_passing_on_nominations') == $yesNo['Yes']) checked  @endif >
                                        <label class="custom-control-label" for="allow_passing_on_nominations"></label>
                                    </div>
                                    @if ($errors->has('allow_passing_on_nominations'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('allow_passing_on_nominations') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('remote_nomination_time_limit') ? ' is-invalid' : '' }}">
                                    <label for="remote_nomination_time_limit">Time limit for remote managers to nominate players</label>

                                    <div class="input-group">
                                      <input type="text" class="form-control" id="remote_nomination_time_limit" name="remote_nomination_time_limit" value="{{ $division->getOptionValue('remote_nomination_time_limit') }}">
                                      <div class="input-group-append">
                                        <span class="input-group-text">seconds</span>
                                      </div>
                                    </div>

                                    @if ($errors->has('remote_nomination_time_limit'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('remote_nomination_time_limit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group @if($division->getOptionValue('allow_passing_on_nominations') != $yesNo['Yes']) d-none  @endif  remote-bidding-time-limit-js {{ $errors->has('remote_bidding_time_limit') ? ' is-invalid' : '' }} ">
                                    <label for="remote_bidding_time_limit">Time limit for remote managers to bid on players</label>

                                    <div class="input-group">
                                      <input type="text" class="form-control" id="remote_bidding_time_limit" name="remote_bidding_time_limit" value="{{ $division->getOptionValue('remote_bidding_time_limit') }}">
                                      <div class="input-group-append">
                                        <span class="input-group-text">seconds</span>
                                      </div>
                                    </div>

                                    @if ($errors->has('remote_bidding_time_limit'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('remote_bidding_time_limit') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="online-sealed-bids-js">
                                <div class="form-group {{ $errors->has('schedule_bidding_rounds') ? ' is-invalid' : '' }}">
                                    <label for="schedule_bidding_rounds" class="required js-bidding-round">Schedule bidding rounds</label>
                                    <div class="form-group row">
    							 		<div class="col-lg-6 col-xl-4">
    							 			<button type="button" class="btn btn-primary btn-block js-bidding-round" data-toggle="{{ count($division->auctionRounds) > 0 ? 'modal' : $division->auction_date == null ? 'modal' : '' }}" data-target="#add_bidding_round_js">schedule</button>
    									</div>
    								</div>
                                    @if ($errors->has('schedule_bidding_rounds'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('schedule_bidding_rounds') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                {{--<div class="form-group automatically-process-bids-js {{ $errors->has('manual_bid') ? ' is-invalid' : '' }}">
                                    <label for="manual_bid" class="required">Automatically process bids? </label>
                                    <div class="custom-control custom-switch">
                                        <input {{$disable}} type="checkbox" class="custom-control-input allow-passing-on-nominations-js" id="manual_bid" name="manual_bid" {{ $division->getOptionValue('manual_bid') == 'No' ? 'checked' : ''}} {{ $division->package->allow_process_bids == 'No' ?'disabled':'' }}>
                                        <label class="custom-control-label" for="manual_bid"></label>
                                    </div>
                                    @if ($errors->has('manual_bid'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('manual_bid') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label>When enabled, round duration will default to 24 hours if rounds are not already scheduled.</label>
                                </div>--}}

                                <div class="form-group {{ $errors->has('tie_preference') ? ' is-invalid' : '' }}">
                                    <label for="tie_preference" class="required">Tie bid preference (how tied bids are settled)</label>
                                    <select {{$disable}} class="custom-select js-select2" id="tie_preference" name="tie_preference">
                                        @foreach($tiePreferenceEnum as $key => $value)
                                            <option value="{{ $key }}" @if($key == $division->getOptionValue('tie_preference')) selected  @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tie_preference'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('tie_preference') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="live-offline-js">
                                <div class="form-group {{ $errors->has('allow_managers_to_enter_own_bids') ? ' is-invalid' : '' }}">
                                    <label for="allow_managers_to_enter_own_bids" class="required">Allow managers to enter their own teams? </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input allow-passing-on-nominations-js" id="allow_managers_to_enter_own_bids" name="allow_managers_to_enter_own_bids" @if($division->allow_managers_to_enter_own_bids == $yesNo['Yes']) checked @endif >
                                        <label class="custom-control-label" for="allow_managers_to_enter_own_bids"></label>
                                    </div>
                                    @if ($errors->has('allow_managers_to_enter_own_bids'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('allow_managers_to_enter_own_bids') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label>When enabled, managers may enter their own winnning bids for their team in the app.</label>
                                </div>
                            </div>

                            <div class="form-group row">
                            	<div class="{{ !$division->isPostAuctionState() ? 'col-md-6':'col-md-12'}}">
                                	<button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                                @if(!$division->isPostAuctionState())
                                    <div class="{{ ! $division->isPostAuctionState() ? 'col-md-6' : '' }}">
                                    	<button data-toggle="modal" data-target="#reset_auction" type="button" class="btn btn-danger btn-block pull-right">Reset Auction</button>
                                    </div>
                                @endif
                            </div>
					</div>
                    <div id="add_bidding_round_js" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content theme-modal">
                                <div class="modal-close-area">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                                    </button>
                                    <div class="f-12">Close</div>
                                </div>
                                <div class="modal-header">
                                    <h5 class="modal-title">Add bidding round</h5>
                                </div>

                                <div class="modal-body">
                                    <div class="main-round-group-js">
                                        <div class="round-group-js">

											@if(count($division->auctionRounds)>0)
												@foreach($division->auctionRounds as $auctionRounds)
												<div class="round-js mb-4">
                                                    <h5 class="text-muted">Round {{$loop->iteration}}</h5>
                                                	@if($loop->iteration<=1)
                                                	<div class="row">
                                                        <div class="form-group col-6">
                                                        	<label for="round_start_date">Start date</label>
                                                           	<input  type="text"
                                                                class="form-control js-datetimepicker-modal"
                                                                id="round_start_date"
                                                                name="round_start_date[{{$auctionRounds->id}}]"
                                                                placeholder="Round Start Date"
                                                                data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                                                data-autoclose="true"
                                                                data-today-highlight="true"
                                                                autocomplete="off"
                                                                value="{{ carbon_format_to_time($auctionRoundStartDate[$loop->index]) }}" {{ $auctionRounds->is_process == 'P'? 'readonly' :''}}>
                                                    	</div>
                                                        <div class="form-group col-6">
                                                            <label for="round_start_date">Start Time</label>
                                                            <input  type="text"
                                                                class="form-control js-timepicker"
                                                                id="round_start_time"
                                                                name="round_start_time[{{$auctionRounds->id}}]"
                                                                placeholder="Round Start time"
                                                                data-autoclose="true"
                                                                data-today-highlight="true"
                                                                autocomplete="off"
                                                                value="{{ $auctionRoundStartTime[$loop->index] }}" {{ $auctionRounds->is_process == 'P'? 'readonly' :''}}>
                                                        </div>
                                                    </div>
                                                	@endif
                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="round_end_date">End date</label>
                                                           	<input type="text"
                                                                class="form-control js-datetimepicker-modal"
                                                                id="round_end_date"
                                                                name="round_end_date[][{{$auctionRounds->id}}]"
                                                                placeholder="Round End Date"
                                                                data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                                                data-autoclose="true"
                                                                data-today-highlight="true"
                                                                autocomplete="off"
                                                                value="{{ carbon_format_to_time($auctionRoundEndDate[$loop->index]) }}" {{ $auctionRounds->is_process == 'P'? 'readonly' :''}}>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label for="round_start_date">End Time</label>
                                                            <input  type="text"
                                                                class="form-control js-timepicker"
                                                                id="round_end_time"
                                                                name="round_end_time[][{{$auctionRounds->id}}]"
                                                                placeholder="Round End time"
                                                                data-autoclose="true"
                                                                data-today-highlight="true"
                                                                autocomplete="off"
                                                                value="{{ $auctionRoundEndTime[$loop->index] }}" {{ $auctionRounds->is_process == 'P'? 'readonly' :''}}>
                                                        </div>
                                                    </div>
                                                </div>
												@endforeach
												@else
												<div class="round-js">
                                                    <h5 class="text-muted">Round 1</h5>
                                                    <div class="row">
														<div class="form-grou col-6">
                                                        	<label for="round_start_date">Start date</label>
                                                     		<input  type="text"
                                                                class="form-control js-datetimepicker-modal"
                                                                id="round_start_date"
                                                                name="round_start_date[]"
                                                                placeholder="Round Start Date"
                                                                data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                                                data-autoclose="true"
                                                                data-today-highlight="true"
                                                                autocomplete="off"
                                                                value="">
                                                    	</div>
                                                        <div class="form-group col-6">
                                                                <label for="round_start_date">Start Time</label>
                                                                <input  type="text"
                                                                    class="form-control js-timepicker"
                                                                    id="round_start_time"
                                                                    name="round_start_time[]"
                                                                    placeholder="Round Start time"
                                                                    data-autoclose="true"
                                                                    data-today-highlight="true"
                                                                    autocomplete="off"
                                                                    value="12:00:00">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        	<div class="form-group col-6">
                                                                <label for="round_end_date">End date</label>
                                                                <input type="text"
                                                                    class="form-control js-datetimepicker-modal"
                                                                    id="round_end_date"
                                                                    name="round_end_date[][]"
                                                                    placeholder="Round End Date"
                                                                    data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                                                    data-autoclose="true"
                                                                    data-today-highlight="true"
                                                                    autocomplete="off"
                                                                    value="">
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="round_start_date">End Time</label>
                                                                <input  type="text"
                                                                    class="form-control js-timepicker"
                                                                    id="round_end_time"
                                                                    name="round_end_time[][]"
                                                                    placeholder="Round End time"
                                                                    data-autoclose="true"
                                                                    data-today-highlight="true"
                                                                    autocomplete="off"
                                                                    value="12:00:00">
                                                            </div>
                                                        </div>
                                                </div>
											@endif

                                        </div>

                                        <div class="form-group">
                                            <input type="button" class="btn btn-primary btn-block" id="add-more-round-js" value="Add another round">
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="list-item text-muted text-sm">
                                                You can change the dates of a round any time before it has started. Typically, five rounds are required to complete an auction.
                                            </li>
                                            <li class="list-item text-muted text-sm">
                                                If future rounds are not scheduled, they will be added automatically with a 24 hour duration.
                                            </li>
                                            <li><strong>To save changes to your round schedule, close this window and hit UPDATE on the Auction Settings page.</strong></li>
                                        </ul>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" >Close</button>
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
  </form>
    <div id="reset_auction" class="modal fade" role="dialog">>
    	<div class="modal-dialog" role="document">
        	<div class="modal-content theme-modal">
            	<div class="modal-close-area">
                	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                    <div class="f-12">Close</div>
                 </div>
                 <div class="modal-header">
                 	<h5 class="modal-title">Reset Auction</h5>
                 </div>
    			 <div class="modal-body">
    			 	<div class="form-group row">
    			 		<div class="col-md-12">
    			 			Are you sure you want to reset auction ?
    			 		</div>
    			 	</div>
    			 	<div class="form-group row">
    			 		<div class="col-md-6">
    			 		<form action="{{ route('manage.division.auction.reset',['division' => $division ]) }}" method="get" class="js-division-reset-form">
                           <button type="submit" class="btn btn-primary btn-block">Yes</button>
    					</form>
    					</div>
                        <div class="col-md-6">
                        	<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-block pull-right">No</button>
                        </div>
                    </div>
    			 </div>
    		</div>
    	</div>
    </div>

    <div id="auctionModal" class="modal fade auctionModal" role="dialog">>
        <div class="modal-dialog" role="document">
            <div class="modal-content theme-modal">
                <div class="modal-close-area">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                    <div class="f-12">Close</div>
                 </div>
                 <div class="modal-header">
                    <h5 class="modal-title">Online Sealed Bids Auction</h5>
                 </div>
                 <div class="modal-body">
                    We are aiming to have Online Sealed Bids ready by the weekend. Any further updates will appear here. Apologies for any inconvenience this may cause.
                 </div>
            </div>
        </div>
    </div>
@endsection
