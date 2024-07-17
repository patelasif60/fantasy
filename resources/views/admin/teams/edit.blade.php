@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/teams/edit.js') }}"></script>
<script src="{{ asset('js/admin/teams/points.js') }}"></script>
<script src="{{ asset('js/admin/teams/player-points.js') }}"></script>
<script src="{{ asset('js/admin/teams/players.js') }}"></script>
<script src="{{ asset('js/admin/teams/transfer-index.js') }}"></script>
<script src="{{ asset('js/admin/teams/transfer-create.js') }}"></script>
<script src="{{ asset('js/admin/teams/adjustments.js') }}"></script>
@endpush

@section('content')

<form class="js-team-edit-form" action="{{ route('admin.teams.update', ['team' => $team]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Team</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row align-items-end">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Team name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" placeholder="Team name" tabindex="1">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="form-group{{ $errors->has('manager_id') ? ' is-invalid' : '' }}">
                        <label for="manager_id" class="required">Manager:</label>
                        <select class="form-control js-select2" id="manager_id" name="manager_id">
                            <option value="">Please select</option>
                            @foreach($managers as $key => $manager)
                                <option value="{{$manager->id}}" @if($team->manager_id == $manager->id) selected @endif>{{$manager->first_name . ' ' . $manager->last_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('manager_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('manager_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-1">
                    <div class="form-group">
                        <a href="{{route('admin.users.consumers.edit', $team->manager_id)}}"><i class="fal fa-fw fa-link fa-2x"></i></a>
                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="form-group{{ $errors->has('division_id') ? ' is-invalid' : '' }}">
                        <label for="division_id" class="required">Division:</label>
                        <select class="form-control js-select2" id="division_id" name="division_id">
                            <option value="">Please select</option>
                            @foreach($divisions as $id => $name)
                                <option value="{{$id}}" @if(isset($team->divisionTeam->division_id) && $team->divisionTeam->division_id == $id) selected @endif>{{$name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('division_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('division_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-1">
                    <div class="form-group">
                        <a href="javascript:void(0);"><i class="fal fa-fw fa-link fa-2x"></i></a>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pitch_id') ? ' is-invalid' : '' }}">
                        <label for="pitch_id">Pitch:</label>
                        <select class="form-control js-select2" id="pitch_id" name="pitch_id">
                            <option value="">Please select</option>
                            @foreach($pitches as $id => $name)
                                <option value="{{$id}}" @if(isset($team->pitch_id) && $team->pitch_id == $id) selected @endif>{{$name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('pitch_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('pitch_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('crest_id') ? ' is-invalid' : '' }}">
                        <label for="crest_id">Badge:</label>
                        <select class="form-control" id="crest_id" name="crest_id">
                            <option value="">Please select</option>
                            @foreach($crests as $key => $crestData)
                                <option data-img="{{$crestData->getMedia('crest')->last() ? $crestData->getMedia('crest')->last()->getUrl('thumb') : ''}}" value="{{$crestData->id}}" @if($team->crest_id == $crestData->id) selected @endif>{{$crestData->name}}</option>
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
                        <input type="file" name="crest" id="crest" data-fileuploader-files='{{ $crest }}'>
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                        @if ($errors->has('crest'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('crest') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('season_quota_used') ? ' is-invalid' : '' }}">
                        <label for="season_quota_used" class="required">Season quota left:</label>
                        <input type="number" max="{{$teamDivision->getOptionValue('season_free_agent_transfer_limit' )}}" step="1"class="form-control" id="season_quota_used" min="0" name="season_quota_used" value="{{ $teamDivision->getOptionValue('season_free_agent_transfer_limit' )-$team->season_quota_used }}" placeholder="Season used quota" tabindex="1">
                        @if ($errors->has('season_quota_used'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('season_quota_used') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('monthly_quota_used') ? ' is-invalid' : '' }}">
                        <label for="monthly_quota_used" class="required">Monthly quota left:</label>
                        <input type="number" max="{{$teamDivision->getOptionValue('monthly_free_agent_transfer_limit' )}}" min="0" step="1" class="form-control" id="monthly_quota_used" name="monthly_quota_used" value="{{$teamDivision->getOptionValue('monthly_free_agent_transfer_limit' )-  $team->monthly_quota_used }}" placeholder="Monthly used quota" tabindex="1">
                        @if ($errors->has('monthly_quota_used'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('monthly_quota_used') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-hero btn-outline-primary float-right js-recalulate-points">Recalulate Points</button>
        </div>
    </div>

    <div class="block">
        <input type="hidden" class="form-control" id="filter-team_id" name="team_id" value={{$team->id}}>
        <input type="hidden" class="form-control" id="filter-uuid" name="uuid" value={{$team->uuid}}>
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

</form>

{{-- Include Teams/Transfer listing file --}}
@include('admin.teams.points.index')

@include('admin.teams.players.index')

@include('admin.teams.transfer.index')

@stop

@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush