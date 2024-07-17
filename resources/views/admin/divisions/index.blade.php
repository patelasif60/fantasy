@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/divisions/index.js') }}"></script>
@endpush

@section('content')
    <form action="#" class="js-filter-form" method="POST">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Filter</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </div>
            </div>
            <div class="block-content block-content-full">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="filter-season-id">Season:</label>
                            <select name="season" id="filter-season-id" class="form-control js-select">
                                <option value="">Please select</option>
                                @foreach($seasons as $id => $season)
                                <option value="{{ $id }}">{{  $season }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="filter-chairman_id">Chairman:</label>
                            <select name="chairman_id" id="filter-chairman_id" class="form-control js-select">
                                <option value="">Please select</option>
                                @foreach($consumers as $id => $consumer)
                                <option value="{{ $consumer->id }}">{{ $consumer->first_name.' '.$consumer->last_name }} ({{ $consumer->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="filter-name">League name:</label>
                            <input type="text" class="form-control" id="filter-name" name="name" placeholder="">
                        </div>
                        <div class="col-6">
                            <label for="filter-status">Status:</label>
                            <select name="status" id="filter-status" class="form-control js-select">
                                <option value="">Please select</option>
                                @foreach($statuses as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">League List</h3>
            <div class="block-options">
                <a href="{{ route('admin.divisions.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new league</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-divisions-list-table" data-url="{{ route('admin.divisions.data') }}"></table>
        </div>
    </div>
@stop
