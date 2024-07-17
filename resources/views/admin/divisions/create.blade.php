@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/divisions/create.js') }}"></script>
@endpush

@section('content')

<form class="js-division-create-form" action="{{ route('admin.divisions.store') }}" method="post">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Division</h3>
            <div class="block-options">
            </div>
        </div>
        <input type="hidden" value="0" id="social_id" name="social_id">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="chairman_id form-group{{ $errors->has('chairman_id') ? ' is-invalid' : '' }}">
                        <label for="chairman_id" class="required">Chairman:</label>
                        <select class="form-control" id="chairman_id" name="chairman_id">
                            <option value="">Please select</option>
                        </select>
                        @if ($errors->has('chairman_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('chairman_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="package_id">Subscription package:</label>
                        <select class="form-control" id="package_id" name="package_id">
                            @foreach($packages as $key => $package)
                                @if( $seasonAvailablePackages && in_array($key, $seasonAvailablePackages))
                                    <option  data-default-id="{{$defaultconsumerId}}" data-default-name = "{{$defaultName}}" data-league-type={{ $leagueType[$package] }}  value="{{ $key }}">{{ $package }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('prize_pack') ? ' is-invalid' : '' }}">
                        <label for="prize_pack">Prize pack:</label>
                        <select class="form-control js-select2" id="prize_pack" name="prize_pack">
                            @foreach($allPrizePacks as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="co_chairman_id">Co-chairmen:</label>
                        <select class="form-control" id="co_chairman_id" name="co_chairman_id[]" multiple="multiple">
                            <option value="">Please select</option>
                        </select>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('parent_division_id') ? ' is-invalid' : '' }}">
                        <label for="parent_division_id">Parent division (league):</label>
                        <select class="form-control" id="parent_division_id" name="parent_division_id">
                            <option value="">No parent division (stanalone league)</option>
                            @foreach($divisions as $id => $name)
                                <option value="{{ $id }}" @if($id == $parentdivision) selected  @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="introduction">Introduction:</label>
                        <textarea class="form-control" id="introduction" rows="3" name="introduction"></textarea>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Division</button>
        <a href="{{ route('admin.divisions.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
