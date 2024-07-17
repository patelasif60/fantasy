@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/settings/squad_and_formations.js') }}"></script>
@endpush

@section('page-name')
    Squad and Formation Settings
@endsection

@section('right')
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'squad_and_formations' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <div class="form-group{{ $errors->has('default_squad_size') ? ' is-invalid' : '' }}">
            <label for="default_squad_size">Squad size:</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="default_squad_size" name="default_squad_size" value="{{ $division->getOptionValue('default_squad_size') }}"  {{ ( $division->package->custom_squad_size == $onlyNoEnum  || $division->isPostAuctionState()) ? 'readonly' : '' }}>
                @if ($errors->has('default_squad_size'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('default_squad_size') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('default_max_player_each_club') ? ' is-invalid' : '' }}">
            <label for="default_max_player_each_club">Club quota</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="default_max_player_each_club" name="default_max_player_each_club" value="{{ $division->getOptionValue('default_max_player_each_club') }}" {{ ( $division->package->custom_club_quota == $onlyNoEnum ) ? 'readonly' : '' }}>
                @if ($errors->has('default_max_player_each_club'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('default_max_player_each_club') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="checkboxfor">Available formations :</label>
            <div class="row gutters-sm">
                @foreach($division->package->available_formations as $key => $value)
                    <div class="custom-control custom-checkbox">
                        <input {{$division->package->allow_available_formations == 'No' ? 'disabled': '' }}  type="checkbox" value="{{$value}}" class="custom-control-input available-formations" id="available_formations-{{$key}}" name="available_formations[]" @if(($division->getOptionValue('available_formations')) && in_array($value, $division->getOptionValue('available_formations'))) checked @endif {{ ($division->isPostAuctionState()) ? 'disabled' : '' }}>
                        <label class="custom-control-label text-white" for="available_formations-{{$key}}">{{$value}}</label>
                    </div>&nbsp;&nbsp;
                </label>
                @endforeach
            </div>
        </div>
        <div class="form-group {{ $errors->has('defensive_midfields') ? ' is-invalid' : '' }}">
            <label for="defensive_midfields" class="required">Use defensive midfielders?:</label>
            <div class="row gutters-sm">
                <select {{$division->package->allow_defensive_midfielders == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="defensive_midfields" name="defensive_midfields" {{ ($division->isPostAuctionState()) ? 'disabled' : '' }}>
                    @foreach($yesNo as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('defensive_midfields')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('defensive_midfields'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('defensive_midfields') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group {{ $errors->has('merge_defenders') ? ' is-invalid' : '' }}">
            <label for="merge_defenders">Merge defenders?:</label>
            <div class="row gutters-sm">
                <select {{$division->package->allow_merge_defenders == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="merge_defenders" name="merge_defenders" {{ ($division->isPostAuctionState()) ? 'disabled' : '' }}>

                    @foreach($yesNo as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('merge_defenders')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('merge_defenders'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('merge_defenders') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group {{ $errors->has('allow_weekend_changes') ? ' is-invalid' : '' }}">
            <label for="allow_weekend_changes" class="required">Allow team changes between first and last matches of the weekend/midweek:</label>
            <div class="row gutters-sm">
                <select {{$division->package->allow_weekend_changes_editable == 'No' ? 'disabled': '' }} class="custom-select js-select2" id="allow_weekend_changes" name="allow_weekend_changes" >

                    @foreach($yesNo as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->getOptionValue('allow_weekend_changes')) selected  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('allow_weekend_changes'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('allow_weekend_changes') }}</strong>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
        </div>
    </form>
@endsection
