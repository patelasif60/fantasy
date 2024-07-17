@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/teams/index.js') }}"></script>
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
                        <label for="division_id">Division:</label>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="">Please select</option>
                            @foreach($divisions as $id => $division)
                                <option value="{{ $id }}">{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="filter-manager_id">Manager:</label>
                        <select class="form-control js-select2" id="manager_id" name="manager_id">
                            <option value="">Please select</option>
                            @foreach($managers as $key => $manager)
                                <option value="{{$manager->id}}">{{$manager->first_name . ' ' . $manager->last_name}} ({{$manager->email}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="filter-name">Team name:</label>
                        <input type="text" class="form-control" id="filter-name" name="name" placeholder="">
                    </div>
                    <div class="col-6">
                        <label for="filter-status">Status:</label>
                        <select name="status" id="filter-status" class="form-control">
                            <option value="">Please select</option>
                            @foreach(config('division.statuses') as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Teams List</h3>
            <div class="block-options">
                <a href="{{ route('admin.teams.create') }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new team</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-teams-list-table" data-url="{{ route('admin.teams.data') }}"></table>
        </div>
    </div>
@stop
