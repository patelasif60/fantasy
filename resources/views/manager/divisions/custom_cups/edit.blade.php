@extends('layouts.manager-league-settings')

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/lodash/lodash.min.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript">
    var allGameweeks = @json($gameweeks);
    var allTeams = @json($teams);
    var cancelUrl = @json($cancelUrl);
    var customCupId = @json($customCup->id);    
    var customCupName = @json($customCup->name);
</script>
<script src="{{ asset('js/manager/mathGlobal.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/custom_cups/edit.js') }}"></script>
@endpush

@section('page-name')
<span class="js-cup-title">{{ $customCup->name }}</span>
@endsection

@section('right')
<div class="js-main-custom-cup"  data-round="{{ route('manage.division.custom.cups.round', ['division' => $division ]) }}">
    <form action="{{ route('manage.division.custom.cups.update',['division' => $division, 'customCup' => $customCup ]) }}" method="POST" class="js-custom-cup-update-form">
        @csrf
        @method('PUT')
        <div class="js-step-one js-step">
            <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="name">Cup name</label>
                <div class="row gutters-sm">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $customCup->name }}" placeholder="e.g. My Custom Cup">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback animated fadeInDown" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('teams') ? ' is-invalid' : '' }}">
                <label for="name">Select the teams you wish to include in your Custom Cup:</label>
                @foreach($teams as $team)
                    <a href="javascript:void(0);" class="link-nostyle team-management-stepper mt-1 mb-3 js-team-checkbox-select">
                        <div class="team-management-block">
                            <div class="team-crest-wrapper">
                                <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $team->getCrestImageThumb() }}"  alt="Team Badge">
                            </div>
                            <div class="team-detail-wrapper d-flex justify-content-between align-items-center flex-grow-1">
                                <div>
                                    <p class="team-title">{{ $team->name }}</p>
                                    <p class="team-owner text-dark">{{ $team->consumer->user->first_name }} {{ $team->consumer->user->last_name }}</p>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-cup-teams" value="{{ $team->id }}"  name="teams[]" id="team-{{$team->id}}" @if(in_array($team->id, $selectedTeams)) checked="checked" @endif>
                                    <label class="custom-control-label" for="team-{{$team->id}}"></label>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                @if ($errors->has('teams'))
                    <span class="invalid-feedback animated fadeInDown" role="alert">
                        <strong>{{ $errors->first('teams') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row justify-content-center">
                <div class="col-6 col-md-6 col-lg-6">
                    <a href="{{ route('manage.division.custom.cups.index', ['division' => $division]) }}" class="btn btn-danger btn-block">Cancel</a>
                </div>
                <div class="col-6 col-md-6 col-lg-6">
                    <a class="js-next-step btn btn-primary btn-block" data-step='2'>Next</a>
                </div>
            </div>
        </div>

        <div class="js-step-two js-step d-none">
            <div class="js-step-rounds">
                <p class="text-center mt-5"><i class="fas fa-spinner fa-spin fa-4x"></i></p>
                <p class="text-center">Fetching Rounds...</p>
            </div>
        </div>

        <div class="js-step-three js-step d-none">
            <div>You have <span class="js-total-team-count"></span> teams for your cup, therefore <span class="js-bye-team-count"></span> will recieve a first round bye.</div>
            <div class="mt-3 mb-5">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input js-first-round-bye" name="is_bye_random" value="0" id="is_bye_random" @if(!$customCup->is_bye_random) checked="checked" @endif>
                    <label class="custom-control-label" for="is_bye_random">Random selection</label>
                </div>
            </div>

            <div class="js-bye-teams-list @if(!$customCup->is_bye_random) d-none @endif">
                <div class="form-group">
                    @foreach($teams as $team)
                        <p>
                            <div class="custom-control custom-checkbox js-bye-team-checkbox" id="js_bye_team_checkbox_{{ $team->id }}">
                                <input type="checkbox" class="custom-control-input" value="{{ $team->id }}"  name="bye_teams[]" id="bye-teams-{{$team->id}}" @if(in_array($team->id, $selectedTeamsBye)) checked="checked" @else disabled="disabled" @endif>
                                <label class="custom-control-label" for="bye-teams-{{$team->id}}">{{ $team->name }}</label>
                            </div>
                        </p>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <a href="javascript:void(0);" class="js-cup-back-url btn btn-danger btn-block">Back</a>
                </div>
                <div class="col-6 col-md-6 col-lg-6">
                    <a class="js-next-step btn btn-primary btn-block" data-step='4'>Next</a>
                </div>
            </div>
        </div>

        <div class="js-step-four js-step d-none">
            The <span class="js-cup-name">{{ $customCup->name }} </span> has been updated. Please check the details below. You can edit your cup until the first week of Round 1.
            <div class="mt-2">
                <strong>Teams:</strong><ul class="js-final-teams"></ul>
            </div>
            <div class="mt-2">
                <strong>Rounds:</strong><ul class="js-final-rounds"></ul>
            </div>
            <div class="mt-2 mb-2 js-final-rounds-byes-main">
                <strong>First round byes:</strong><ul class="js-final-rounds-byes"></ul>
            </div>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <a href="javascript:void(0);" class="js-cup-back-url btn btn-danger btn-block">Back</a>
                </div>
                <div class="col-6 col-md-6 col-lg-6">
                    <button class="btn btn-primary btn-block js-step-submit">Done</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection