@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/players/create.js') }}"></script>
@endpush

@section('content')

<form class="js-player-create-form" action="{{ route('admin.players.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Player</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="first_name">First name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First name">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                        <label for="last_name" class="required">Last name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                        @if ($errors->has('last_name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('short_code') ? ' is-invalid' : '' }}">
                        <label for="short_code">Shortcode:</label>
                        <input type="text" class="form-control" id="short_code" name="short_code" value="{{ old('short_code') }}" placeholder="Short code">
                        @if ($errors->has('short_code'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('short_code') }}</strong>
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
                    <div class="form-group {{ $errors->has('player_image') ? ' is-invalid' : '' }}">
                        <label for="player_image">Player image:</label>
                        <input type="file" name="player_image" id="player_image">
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 640px &times; 260px</div>
                        @if ($errors->has('player_image'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('player_image') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Player</button>
        <a href="{{ route('admin.players.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
