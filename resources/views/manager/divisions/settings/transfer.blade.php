@extends('layouts.manager-league-settings')

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
    <script src="{{ asset('js/manager/divisions/settings/transfer.js') }}"></script>
@endpush

@section('page-name')
    Transfers and Sealed Bids Settings
@endsection

@section('right')
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'transfer' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <div class="form-group{{ $errors->has('seal_bids_budget') ? ' is-invalid' : '' }}">
            <label for="seal_bids_budget">Season Budget:</label>
            <input {{$division->package->allow_season_budget == 'Yes' ? '': 'readonly' }}  type="text" class="form-control" id="seal_bids_budget" name="seal_bids_budget"  value="{{$division->getOptionValue('seal_bids_budget')}}">
            @if ($errors->has('seal_bids_budget'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('seal_bids_budget') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('enable_free_agent_transfer') ? ' is-invalid' : '' }}">
            <label for="enable_free_agent_transfer">Allow transfers outside of sealed bid windows :</label>
                <div class="row gutters-sm">
                    <select  {{$division->package->allow_enable_free_agent_transfer == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="enable_free_agent_transfer" name="enable_free_agent_transfer">

                        @foreach($yesNo as $key => $value)
                            <option value="{{ $key }}" @if($key == $division->getOptionValue('enable_free_agent_transfer')) selected  @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            @if ($errors->has('enable_free_agent_transfer'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('enable_free_agent_transfer') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('free_agent_transfer_authority') ? ' is-invalid' : '' }}">
            <label for="free_agent_transfer_authority">Transfer authority:</label>
                <div class="row gutters-sm">
                <select  {{$division->package->allow_free_agent_transfer_authority == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="free_agent_transfer_authority" name="free_agent_transfer_authority">

                    @foreach($transferAuthority as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('free_agent_transfer_authority')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('free_agent_transfer_authority'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('free_agent_transfer_authority') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('free_agent_transfer_after') ? ' is-invalid' : '' }}">
            <label for="free_agent_transfer_after">Transfers deducted from quota :</label>
                <div class="row gutters-sm">
                <select {{$division->package->allow_free_agent_transfer_after == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="free_agent_transfer_after" name="free_agent_transfer_after">

                    @foreach($agentTransferAfterEnum as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('free_agent_transfer_after')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('free_agent_transfer_after'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('free_agent_transfer_after') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('season_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
            <label for="season_free_agent_transfer_limit">Season transfer limit:</label>
            <input {{$division->package->allow_season_free_agent_transfer_limit == 'No' ? 'disabled': '' }}  type="text" class="form-control" id="season_free_agent_transfer_limit" name="season_free_agent_transfer_limit"  value="{{$division->getOptionValue('season_free_agent_transfer_limit')}}">
            @if ($errors->has('season_free_agent_transfer_limit'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('season_free_agent_transfer_limit') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('monthly_free_agent_transfer_limit') ? ' is-invalid' : '' }}">
            <label for="monthly_free_agent_transfer_limit">Monthly transfer limit:</label>
            <input  {{$division->package->allow_monthly_free_agent_transfer_limit == 'No' ? 'disabled': '' }}  type="text" class="form-control" id="monthly_free_agent_transfer_limit" name="monthly_free_agent_transfer_limit" value="{{$division->getOptionValue('monthly_free_agent_transfer_limit')}}">
            @if ($errors->has('monthly_free_agent_transfer_limit'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('monthly_free_agent_transfer_limit') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('seal_bid_deadline_repeat') ? ' is-invalid' : '' }}">
            <label for="seal_bid_deadline_repeat">Sealed Bids round deadline repeat:</label>
            <select {{ ! $division->isPostAuctionState() ? 'disabled' : $division->package->allow_seal_bid_deadline_repeat == 'No' ? 'disabled': '' }} class="form-control js-select2" id="seal_bid_deadline_repeat" name="seal_bid_deadline_repeat">
                @foreach($sealedBidDeadLinesEnum as $key => $value)
                    <option value="{{ $key }}" @if($key == $division->getOptionValue('seal_bid_deadline_repeat')) selected  @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>

        @if($division->isPostAuctionState())
            <div class="form-group js-div-manually-round-create">
                <button type="button" class="btn btn-primary js-btn-manually-round-create">Schedule</button>
            </div>

            <div class="modal fade js-round-create-modal text-dark" tabindex="-1" role="dialog" aria-labelledby="round-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content theme-modal">
                        <div class="modal-close-area">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                            </button>
                            <div class="f-12">Close</div>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title">Sealed Bids Rounds</h5>
                        </div>
                        <div class="modal-body">
                            @foreach($transferRounds as $transferRound)
                            <div class="round-js">
                                <h5 class="text-muted">Round {{ $transferRound->number }}</h5>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="round_end_date">End date</label>
                                        <input type="text"
                                            class="form-control js-datetimepicker-modal"
                                            id="round_end_date"
                                            name="round_end_date[][{{ $transferRound->id }}]"
                                            placeholder="Round End Date"
                                            data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off"
                                            @if($transferRound->is_process == 'P') readonly @endif
                                            value="{{ get_date_time_in_carbon($transferRound->end)->format('d-m-Y') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="round_start_date">End Time</label>
                                        <input  type="text"
                                            class="form-control js-timepicker"
                                            id="round_end_time"
                                            name="round_end_time[][{{ $transferRound->id }}]"
                                            placeholder="Round End time"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off"
                                            @if($transferRound->is_process == 'P') readonly @endif
                                            value="{{ get_date_time_in_carbon($transferRound->end)->format('H:i:s') }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="js-new-rounds-area"></div>
                            <div class="form-group mt-2">
                                <input type="button" class="btn btn-primary btn-block" data-round="@if($transferRounds) {{ $transferRound->number }} @else 0 @endif" id="add-more-round-js" @if($unprocessRoundCount >= 1) disabled="disabled" @endif value="Add another round">
                            </div>
                            <ul class="list-unstyled">
                                <li><strong>To save changes to your round schedule, close this window and hit UPDATE on the Transfers and sealed bids settings page.</strong></li>
                            </ul>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" >Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group{{ $errors->has('max_seal_bids_per_team_per_round') ? ' is-invalid' : '' }}">
            <label for="max_seal_bids_per_team_per_round">Max bids per round:</label>
            <input {{ $division->package->allow_max_bids_per_round == 'No' ? 'disabled': '' }} type="text" class="form-control" id="max_seal_bids_per_team_per_round" name="max_seal_bids_per_team_per_round" value="{{$division->getOptionValue('max_seal_bids_per_team_per_round')}}">
        </div>

        <div class="form-group{{ $errors->has('seal_bid_increment') ? ' is-invalid' : '' }}">
            <label for="seal_bid_increment">Sealed Bids bid increment:</label>
            <input {{$division->package->allow_bid_increment == 'No' ? 'disabled': '' }} type="text" class="form-control" id="seal_bid_increment" name="seal_bid_increment" value="{{$division->getOptionValue('seal_bid_increment')}}">
        </div>
        <div class="form-group{{ $errors->has('seal_bid_minimum') ? ' is-invalid' : '' }}">
            <label for="seal_bid_minimum">Sealed Bids minimum bid:</label>
            <input {{$division->package->allow_seal_bid_minimum == 'No' ? 'disabled': '' }} type="text" class="form-control" id="seal_bid_minimum" name="seal_bid_minimum" value="{{$division->getOptionValue('seal_bid_minimum')}}">
        </div>
        <div class="form-group{{ $errors->has('money_back') ? ' is-invalid' : '' }}">
            <label for="money_back">Sealed Bids money back:</label>
            <select {{$division->package->allow_money_back == 'No' ? 'disabled': '' }} class="form-control js-select2" id="money_back" name="money_back">

                @foreach($division->package->money_back_types as $key => $value)
                    <option value="{{ $value }}" @if($value == $division->getOptionValue('money_back')) selected  @endif>{{$moneyBackEnum[$value]}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group{{ $errors->has('tie_preference') ? ' is-invalid' : '' }}">
            <label for="tie_preference">Sealed Bids tie preference:</label>
            <select {{ ! $division->isPostAuctionState() ? 'disabled' : $division->package->allow_tie_preference == 'No' ? 'disabled': '' }} class="form-control js-select2" id="tie_preference" name="tie_preference">
                @foreach($tiePreferenceEnum as $key => $value)
                    <option value="{{ $key }}" @if($key == $division->getOptionValue('tie_preference')) selected  @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block btn-transfer-submit">Update</button>
            </div>
        </div>
    </form>
@endsection
