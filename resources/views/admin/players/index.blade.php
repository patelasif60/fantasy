@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/players/index.js') }}"></script>
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
                        <div class="col-4">
                            <label for="filter-club">Club:</label>
                            <select name="club" id="filter-club" class="form-control">
                                <option value=""></option>
                                @foreach($clubs as $id => $club)
                                    <option value="{{ $id }}">{{ $club }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="filter-position">Position:</label>
                            <select name="position" id="filter-position" class="form-control">
                                <option value=""></option>
                                 @foreach($positions as $position)
                                    <option value="{{ $position }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="filter-term">Name:</label>
                            <input type="text" class="form-control" id="filter-term" name="term" placeholder="Search name">
                        </div>
                    </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Player List</h3>
            <div class="block-options">
                <a href="{{ route('admin.players.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new player</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-players-list-table" data-url="{{ route('admin.players.data') }}"></table>
        </div>
    </div>
@stop
