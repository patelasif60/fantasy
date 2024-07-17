@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/history/edit.js') }}"></script>
@endpush

@section('page-name')
{{ $selectedhistory->name }}
@endsection

@section('left')
    <ul class="custom-list-group list-group-white">
        @foreach($histories as $history)
            <li>
                <div class="list-element">
                    <a href="{{ route('manage.division.history.edit',['division' => $division, 'history' => $history ]) }}" class="has-stepper has-text">
                        <span>@php echo substr($history->season->name,2,2).'/'.substr($history->season->name,-2,2);@endphp</span>
                        <span class="has-icon">{{ $history->name }}</span>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@endsection

@section('right')
    <form action="{{ route('manage.division.history.update',['division' => $division, 'history' => $selectedhistory->id]) }}" method="POST" class="js-history-update-form">
        @csrf
        @method('PUT')
        <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
            <label for="name" class="required">Name:</label>
            <div class="row gutters-sm">
                <select class="custom-select js-select2" id="name" name="name">
                    @foreach($customMargeArrayManager as $manager)
                        <option value="{{$manager}}" {{$manager == $selectedhistory->name ? 'selected' : '' }}>{{ $manager}}</option>
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
                        <option value="{{ $season->id }}" @if($season->id == $selectedhistory->season_id) selected  @endif>{{ $season->name }}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('season_id'))
                <div class="invalid-feedback animated fadeInDown">
                    <strong>{{ $errors->first('season_id') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-xs-12">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
            <div class="col-md-6 col-xs-12">
               <a href="{{ route('manage.division.history.remove',['division' => $division,'history' => $selectedhistory->id]) }}" class="btn btn-danger btn-block delete-confirmation-button status is-delete">Delete</a>
            </div>
        </div>
    </form>
@endsection
