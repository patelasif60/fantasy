@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/settings/league.js') }}"></script>
@endpush

@section('right')
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'league' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
            <label for="nameAddress">League name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $division->name }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('package_id') ? ' is-invalid' : '' }}">
            <label for="package_id" class="required">Package:</label>
            <select @can('packageDisabled', $division) disabled @endcan class="custom-select js-select2" id="package_id" name="package_id">
                @foreach($packages as $package)
                    @if( $seasonAvailablePackages && in_array($package->id, $seasonAvailablePackages))
                        <option value="{{ $package->id }}" @if($package->id == $division->package_id) selected  @endif>{{ $package->name }}</option>
                    @endif
                @endforeach
            </select>
            @if ($errors->has('package_id'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('package_id') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('chairman_id') ? ' is-invalid' : '' }}">
            <label for="chairman_id" class="required">Chairman:</label>
            <select class="custom-select js-select2 js-chairman" id="chairman_id" name="chairman_id" data-prev-id="{{$division->chairman_id}}">
                <option data-id={{$division->chairman_id}} value="{{$division->chairman_id}}" selected>{{$division->consumer->user->first_name.' '.$division->consumer->user->last_name}}</option>
                @foreach($consumers as $id => $consumer)
                     @if($consumer->id != $division->chairman_id)
                        <option data-id={{$consumer->id}} value="{{ $consumer->id }}">{{ $consumer->user->first_name.' '.$consumer->user->last_name }}</option>
                    @endif
                @endforeach
            </select>
            @if ($errors->has('chairman_id'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('chairman_id') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group {{ $errors->has('co_chairman_id') ? ' is-invalid' : '' }}">
            <label for="co_chairman_id" class="required">Co-chairman:</label>
                <select class="custom-select js-select2 js-co_chairman" id="co_chairman_id" name="co_chairman_id[]" data-prev-id[]="" multiple="multiple">
                    @foreach($consumers as $id => $consumer)
                        @if($consumer->id != $division->chairman_id)
                            <option data-id={{$consumer->id}} value="{{ $consumer->id }}" @if($division->coChairmen->pluck('id')->contains($consumer->id)) selected  @endif>{{ $consumer->user->first_name.' '.$consumer->user->last_name }}</option>
                        @endif
                    @endforeach
                </select>
            @if ($errors->has('co_chairman_id'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('co_chairman_id') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group{{ $errors->has('introduction') ? ' is-invalid' : '' }}">
            <label for="introduction">League Message:</label>
            <textarea class="form-control js-summernote" name="introduction" id="introduction">{{ $division->introduction }}</textarea>
            @if ($errors->has('introduction'))
                <span class="invalid-feedback animated fadeInDown" role="alert">
                    <strong>{{ $errors->first('introduction') }}</strong>
                </span>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
        </div>
    </form>
@endsection
