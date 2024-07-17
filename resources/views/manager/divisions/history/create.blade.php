@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/history/create.js') }}"></script>
@endpush

@section('page-name')
Add Previous Winner
@endsection

@section('right')
    <form action="{{ route('manage.division.history.store',['division' => $division]) }}" method="POST" class="js-history-create-form">
        @csrf
        <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
            <label for="name" class="required">Name:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="name" name="name">
                    @foreach($managers as $id => $manager)
                      <option value="{{ $manager->user->first_name.' '.$manager->user->last_name }}">{{ $manager->user->first_name.' '.$manager->user->last_name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('name'))
                    <div class="invalid-feedback animated fadeInDown">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('season_id') ? ' is-invalid' : '' }}">
            <label for="season_id" class="required">Season:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="season_id" name="season_id">
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}" @if($season->id == old('season')) selected  @endif>{{ $season->name }}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('season_id'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('season_id') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Create</button>
        </div>
    </form>
@endsection