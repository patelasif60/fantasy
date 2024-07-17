@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/seasons/edit.js') }}"></script>
<script src="{{ asset('js/admin/game_week/create.js') }}"></script>
<script src="{{ asset('js/admin/game_week/edit.js') }}"></script>
<script src="{{ asset('js/admin/game_week/index.js') }}"></script>
@endpush

@section('content')

<form class="js-season-edit-form" action="{{ route('admin.seasons.update', ['season' => $season]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
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
                        <input type="text" class="form-control" id="name" name="name" placeholder="Season name" value="{{ $season->name }}">
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
                                <option value="{{ $key }}" @if(in_array($key, array_get($season,'available_packages',[]))) selected  @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('package') ? ' is-invalid' : '' }}">
                        <label for="default_package" class="required">Default package for new user:</label>
                        <select name="package_id" id="default_package" class="form-control js-select2">
                            <option value="">Select Package</option>
                            @foreach($packages as $id => $package)
                                @if( in_array($id, array_get($season,'available_packages',[])))
                                    <option value="{{ $id }}" @if($id == $season->default_package) selected ="selected" @endif>{{ $package }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('default_package_for_existing_user') ? ' is-invalid' : '' }}">
                        <label for="default_package_for_existing_user" class="required">Default package for existing  user:</label>
                        <select name="default_package_for_existing_user" id="default_package_for_existing_user" class="form-control js-select2">
                            <option value="">Select Package</option>
                            @foreach($packages as $id => $package)
                                @if( in_array($id, array_get($season,'available_packages',[])))
                                    <option value="{{ $id }}" @if($id == $season->default_package_for_existing_user) selected ="selected" @endif>{{ $package }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('premier_api_id') ? ' is-invalid' : '' }}">
                        <label for="premier_api_id" class="required">Premier league season API ID:</label>
                        <input type="text" class="form-control" id="premier_api_id" name="premier_api_id" placeholder="Premier League Season API ID" value="{{ $season->premier_api_id }}">
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
                        <input type="text" class="form-control" id="facup_api_id" name="facup_api_id" placeholder="FA Cup Season API ID" value="{{ $season->facup_api_id }}">
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
                        value="{{ carbon_format_to_date($season->start_at) }}"
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
                        value="{{ carbon_format_to_date($season->end_at) }}"
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update data</button>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_rollover_leagues" class="btn btn-hero btn-noborder btn-alt-secondary"> Rollover data</a>
        <a href="{{ route('admin.seasons.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>

<div class="block">
<div class="block-header block-header-default">
    <h3 class="block-title">Game weeks</h3>
    <div class="block-options">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_game_week_create" class="btn btn-sm btn-outline-primary"> Add game week</a>
    </div>
</div>
<div class="block-content block-content-full">
    <table class="table table-striped table-vcenter table-hover admin-game-week-list-table" data-url="{{ route('admin.gameweeks.data',['season' => $season]) }}"></table>
</div>
</div>


@stop

@push('modals')
<!-- Fade In Modal -->
<div class="modal fade" id="modal_rollover_leagues" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    @include('admin.seasons.rollover.create')
</div>

<div class="modal fade" id="modal_game_week_create" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    @include('admin.seasons.game_week.create')
</div>

<div class="modal fade" id="modal_game_week_edit"  tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
</div>
<!-- END Fade In Modal -->
@endpush
