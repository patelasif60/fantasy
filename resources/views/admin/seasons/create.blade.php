@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/seasons/create.js') }}"></script>
@endpush

@section('content')

<form class="js-season-create-form" action="{{ route('admin.seasons.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Season</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Season name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Season name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6"></div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('available_packages') ? ' is-invalid' : '' }}">
                        <label for="available_packages" class="required">Available packages:</label>
                        <select class="form-control js-select2" id="available_packages" name="available_packages[]" multiple="multiple">
                            @foreach($packages as $key => $value)
                                <option value="{{ $key }}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('package') ? ' is-invalid' : '' }}">
                        <label for="default_package" class="required">Default package for new user:</label>
                        <select name="package_id" id="default_package" class="form-control js-select2">
                            <option value="">Select Package</option>
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('default_package_for_existing_user') ? ' is-invalid' : '' }}">
                        <label for="default_package_for_existing_user" class="required">Default package for existing  user:</label>
                        <select name="default_package_for_existing_user" id="default_package_for_existing_user" class="form-control js-select2">
                            <option value="">Select Package</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('premier_api_id') ? ' is-invalid' : '' }}">
                        <label for="premier_api_id" class="required">Premier league season API ID:</label>
                        <input type="text" class="form-control" id="premier_api_id" name="premier_api_id" value="{{ old('premier_api_id') }}" placeholder="Premier League Season API ID">
                        @if ($errors->has('premier_api_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('premier_api_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('facup_api_id') ? ' is-invalid' : '' }}">
                        <label for="facup_api_id" class="required">FA cup season API ID:</label>
                        <input type="text" class="form-control" id="facup_api_id" name="facup_api_id" value="{{ old('facup_api_id') }}" placeholder="FA Cup Season API ID">
                        @if ($errors->has('facup_api_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('facup_api_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('start_at') ? ' is-invalid' : '' }}">
                        <label for="start_at" class="required">Season start:</label>
                        <input type="text" class="form-control js-datepicker"
                        id="start_at"
                        name="start_at"
                        value=""
                        placeholder="Season start"
                        data-date-format="{{config('fantasy.datepicker.format')}}"
                        data-week-start="1"
                        data-autoclose="true"
                        data-today-highlight="true"
                        autocomplete="off">
                        @if ($errors->has('start_at'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('start_at') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('end_at') ? ' is-invalid' : '' }}">
                        <label for="end_at" class="required">Season end:</label>
                        <input type="text" class="form-control js-datepicker"
                        id="end_at"
                        name="end_at"
                        value=""
                        placeholder="Season end"
                        data-date-format="{{config('fantasy.datepicker.format')}}"
                        data-week-start="1"
                        data-autoclose="true"
                        data-today-highlight="true"
                        autocomplete="off">
                        @if ($errors->has('end_at'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('end_at') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Season</button>
        <a href="{{ route('admin.seasons.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
