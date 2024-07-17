@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/settings/sealed_bids.js') }}"></script>
@endpush

@section('page-name')
Sealed Bids Settings
@endsection

@section('right')
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'sealed_bids' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <div class="form-group{{ $errors->has('seal_bids_budget') ? ' is-invalid' : '' }}">
            <label for="seal_bids_budget">Season budget</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="seal_bids_budget" name="seal_bids_budget" value="{{ $division->getOptionValue('seal_bids_budget') }}">
                @if ($errors->has('seal_bids_budget'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('seal_bids_budget') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('seal_bid_increment') ? ' is-invalid' : '' }}">
            <label for="seal_bid_increment">Bid increment</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="seal_bid_increment" name="seal_bid_increment" value="{{ $division->getOptionValue('seal_bid_increment') }}">
                @if ($errors->has('seal_bid_increment'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('seal_bid_increment') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('seal_bid_minimum') ? ' is-invalid' : '' }}">
            <label for="seal_bid_minimum">Minimum bid</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="seal_bid_minimum" name="seal_bid_minimum" value="{{ $division->getOptionValue('seal_bid_minimum') }}">
                @if ($errors->has('seal_bid_minimum'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('seal_bid_minimum') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('manual_bid') ? ' is-invalid' : '' }}">
            <label for="manual_bid" class="required">Automatically approve bids?:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="manual_bid" name="manual_bid">
                    <option value="">Package Default</option>
                    @foreach($yesNo as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('manual_bid')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('manual_bid'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('manual_bid') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group{{ $errors->has('first_seal_bid_deadline') ? ' is-invalid' : '' }}">
            <label for="first_seal_bid_deadline">Rounds deadline</label>
            <div class="row gutters-sm">
                <input type="text"
                class="form-control js-datetimepicker"
                id="first_seal_bid_deadline"
                name="first_seal_bid_deadline"
                placeholder="Package Default"
                data-date-format="{{config('fantasy.datetimepicker.format')}}"
                data-autoclose="true"
                data-today-highlight="true"
                autocomplete="off"
                value="{{ carbon_format_to_time($division->getOptionValue('first_seal_bid_deadline')) }}">
            </div>
            @if ($errors->has('first_seal_bid_deadline'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('first_seal_bid_deadline') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('seal_bid_deadline_repeat') ? ' is-invalid' : '' }}">
            <label for="seal_bid_deadline_repeat" class="required">Round deadline repeats:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="seal_bid_deadline_repeat" name="seal_bid_deadline_repeat">
                    <option value="">Package Default</option>
                    @foreach($sealedBidDeadLinesEnum as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('seal_bid_deadline_repeat')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('seal_bid_deadline_repeat'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('seal_bid_deadline_repeat') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group{{ $errors->has('max_seal_bids_per_team_per_round') ? ' is-invalid' : '' }}">
            <label for="max_seal_bids_per_team_per_round">Maximum bids per team:</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="max_seal_bids_per_team_per_round" name="max_seal_bids_per_team_per_round" value="{{ $division->getOptionValue('max_seal_bids_per_team_per_round') }}">
                @if ($errors->has('max_seal_bids_per_team_per_round'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('max_seal_bids_per_team_per_round') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('money_back') ? ' is-invalid' : '' }}">
            <label for="money_back" class="required">Money back for departing players:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="money_back" name="money_back">
                    <option value="">Package Default</option>
                    @foreach($moneyBackEnum as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('money_back')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('money_back'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('money_back') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group {{ $errors->has('tie_preference') ? ' is-invalid' : '' }}">
            <label for="tie_preference" class="required">Tie preference:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="tie_preference" name="tie_preference">
                    <option value="">Package Default</option>
                    @foreach($tiePreferenceEnum as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('tie_preference')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('tie_preference'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('tie_preference') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group{{ $errors->has('rules') ? ' is-invalid' : '' }}">
            <label for="rules">Rules:</label>
            <div class="row gutters-sm">
                <textarea class="form-control" rows="5" name="rules" id="rules">{{ $division->rules }}</textarea>
            </div>
            @if ($errors->has('rules'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('rules') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </form>
@endsection