@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/fixtures/edit.js') }}"></script>
<script src="{{ asset('js/admin/fixtures/event.js') }}"></script>
<script src="{{ asset('js/admin/fixtures/notEqualToGroup.validation.js') }}"></script>
<script src="{{ asset('js/admin/fixtures/lineup.js') }}"></script>

@endpush

@section('content')

<form class="js-fixture-edit-form" action="{{ route('admin.fixtures.update', ['fixture' => $fixture]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit fixture</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('season') ? ' is-invalid' : '' }}">
                        <label for="filter-season" class="required">Season:</label>
                        <select name="season" id="filter-season" class="form-control js-select2">
                            <option value=""></option>
                            @foreach($seasons as $id => $ssn)
                                <option @if( $fixture->season_id  == $id) selected="selected" @endif value="{{ $id }}">{{ $ssn }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('season'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('season') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('competition') ? ' is-invalid' : '' }}">
                        <label for="filter-competition" class="required">Competition:</label>
                        <select name="competition" id="filter-competition" class="form-control js-select2">
                            <option value=""></option>
                            @foreach($competitions as $competition)
                                <option @if($fixture->competition == $competition) selected="selected" @endif value="{{ $competition }}">{{ $competition }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('competition'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('competition') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('home_club') ? ' is-invalid' : '' }}">
                        <label for="filter-home-club" class="required">Home Team:</label>
                        <select name="home_club" id="filter-home-club" class="form-control js-select2">
                            <option value=""></option>
                            @foreach($clubs as $id => $club)
                                <option @if($fixture->home_club_id == $id) selected="selected" @endif value="{{ $id }}">{{ $club }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('home_club'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('home_club') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('away_club') ? ' is-invalid' : '' }}">
                        <label for="filter-away-club" class="required">Away Team:</label>
                        <select name="away_club" id="filter-away-club" class="form-control js-select2">
                            <option value=""></option>
                            @foreach($clubs as $id => $club)
                                <option @if($fixture->away_club_id == $id) selected="selected" @endif value="{{ $id }}">{{ $club }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('away_club'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('away_club') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">

                    <div class="form-group{{ $errors->has('date') ? ' is-invalid' : '' }}">
                        <label for="date" class="required">Date:</label>
                        <input type="text"
                        class="form-control"
                        id="date"
                        name="date"
                        value="{{ carbon_format_to_time($fixture->date_time) }}"
                        placeholder="Date"
                        data-date-format="{{config('fantasy.datetimedatepicker.format')}}"
                        data-week-start="1"
                        data-autoclose="true"
                        data-today-highlight="true"
                        autocomplete="off">
                        @if ($errors->has('date'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('date') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('time') ? ' is-invalid' : '' }}">
                        @php
                            $time = carbon_format_to_time($fixture->date_time);
                        @endphp
                        <label for="time" class="required">Time:</label>
                        <input type="text"
                        class="form-control"
                        id="time"
                        name="time"
                        value="{{ substr($time, 10, strlen($time)) }}"
                        placeholder="Time"
                        data-date-format="{{config('fantasy.datetimetimepicker.format')}}"
                        data-week-start="1"
                        data-autoclose="true"
                        data-today-highlight="true"
                        autocomplete="off">
                        @if ($errors->has('time'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('time') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('api_id') ? ' is-invalid' : '' }}">
                        <label for="api_id" class="required">API ID:</label>
                        <input type="text" class="form-control" id="api_id" name="api_id" value="{{ $fixture->api_id }}" placeholder="API ID">
                        @if ($errors->has('api_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('api_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Save</button>
        <a href="{{route('admin.fixtures.destroy',['fixture' => $fixture])}}" title="Delete" class="btn btn-hero btn-noborder btn-alt-danger delete-confirmation-button">Delete</a>
        <a href="{{ route('admin.fixtures.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>

@include('admin.fixtures.event.index')
@include('admin.fixtures.lineup.index')

@stop

@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush

