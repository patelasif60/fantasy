@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/european_cups.js') }}"></script>
@endpush

@section('page-name')
European Competitions Settings
@endsection

@section('right')
    @if($division->package->allow_europa_league == \App\Enums\YesNoEnum::YES)
        <p>Select your European competition representatives for this season - most commonly the top three teams from last season.</p>
    @else
        <p>European Competitions should only be available for 'Pro' and 'Legend' packages.</p>
    @endif
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'european_cups' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <div class="form-group">
            <label for="champions_league_team" class="required">Champions League Team</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="champions_league_team" name="champions_league_team" @if($isStart) disabled  @endif>
                    <option value=""></option>
                    @foreach($teams as $key => $value)
                        <option value="{{ $key }}" @if($key == $division->champions_league_team) selected  @endif {{ $key == $division->europa_league_team_1 || $key == $division->europa_league_team_2 ? 'disabled' : '' }}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="europa_league_team_1" class="required">Europa League Team 1</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="europa_league_team_1" name="europa_league_team_1" @if($isStart) disabled  @endif>
                        <option value=""></option>
                        @foreach($teams as $key => $value)
                        <option data-team-id="{{$key}}" value="{{ $key }}" @if($key == $division->europa_league_team_1) selected  @endif @if($key == $division->europa_league_team_2 || $key == $division->champions_league_team) disabled  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="europa_league_team_2" class="required">Europa League Team 2</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="europa_league_team_2" name="europa_league_team_2" @if($isStart) disabled  @endif>
                    <option value=""></option>
                    @foreach($teams as $key => $value)
                        <option data-team-id="{{$key}}" value="{{ $key }}" @if($key == $division->europa_league_team_2) selected  @endif @if($key == $division->europa_league_team_1 || $key == $division->champions_league_team) disabled  @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block" @if($isStart) disabled  @endif>Update</button>
            </div>
        </div>
    </form>
@endsection
