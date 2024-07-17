@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/players/edit.js') }}"></script>
<script src="{{ asset('js/admin/players/contract.js') }}"></script>
<script src="{{ asset('js/admin/players/status.js') }}"></script>
@endpush

@section('content')

<form class="js-player-edit-form" action="{{ route('admin.players.update', ['player' => $player]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Player</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="first_name">First name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $player->first_name }}" placeholder="First name">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                        <label for="last_name" class="required">Last name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $player->last_name }}" placeholder="Last name">
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
                        <input type="text" class="form-control" id="short_code" name="short_code" value="{{ $player->short_code }}" placeholder="Short code">
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
                        <input type="text" class="form-control" id="api_id" name="api_id" value="{{ $player->api_id }}" placeholder="API ID">
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
                        <input type="file" name="player_image" id="player_image" data-fileuploader-files='{{ $playerImage }}'>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Edit Player</button>
        <a href="{{ route('admin.players.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
<div class="block">
	<div class="block-header block-header-default">
		<h3 class="block-title">Contract</h3>
		<div class="block-options">
			<button href="{{ route('admin.player.contract.create',['player' => $player]) }}" class="btn btn-outline-primary fetch_create_edit_modal"><i class="fal fa-plus mr-5"></i>Add Contract</button>
		</div>
	</div>
	<div class="block-content block-content-full">
		<table class="table table-striped table-vcenter table-hover admin-players-contract-list-table" data-url="{{ route('admin.player.contract.data',['player' => $player]) }}"></table>
	</div>
</div>

<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Status History</h3>
        <div class="block-options">
            <button type="button" href="{{ route('admin.player.status.create',['player' => $player]) }}" class="btn btn-outline-primary fetch_create_edit_modal"><i class="fal fa-plus mr-5"></i>Add status</button>
        </div>
    </div>
    <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter table-hover admin-players-status-list-table" data-url="{{ route('admin.player.status.data',['player' => $player]) }}"></table>
    </div>
</div>

@stop


@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
</div>
@endpush
