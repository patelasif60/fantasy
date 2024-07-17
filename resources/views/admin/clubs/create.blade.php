@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/clubs/create.js') }}"></script>
@endpush

@section('content')

<form class="js-club-create-form" action="{{ route('admin.clubs.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Club</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">

                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Club name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Club name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('api_id') ? ' is-invalid' : '' }}">
                        <label for="api_id" class="required">API ID:</label>
                        <input type="text" class="form-control" id="api_id" name="api_id" value="{{ old('api_id') }}" placeholder="API ID">
                        @if ($errors->has('api_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('api_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('short_name') ? ' is-invalid' : '' }}">
                        <label for="short_name" class="required">Short name:</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name') }}" placeholder="Short name">
                        @if ($errors->has('short_name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('short_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('short_code') ? ' is-invalid' : '' }}">
                        <label for="short_code" class="required">Short code:</label>
                        <input type="text" class="form-control" id="short_code" name="short_code" value="{{ old('short_code') }}" placeholder="Short code">
                        @if ($errors->has('short_code'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('short_code') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('is_premier') ? ' is-invalid' : '' }}">
                        <div class="row no-gutters items-push">
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" name="is_premier">
                                <span class="css-control-indicator"></span> Is Premier League Club
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                        <label for="photo">Badge:</label>
                        <input type="file" name="crest" id="crest">
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                        @if ($errors->has('crest'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('crest') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Club</button>
        <a href="{{ route('admin.clubs.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
