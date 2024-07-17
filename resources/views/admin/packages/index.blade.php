@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/packages/index.js') }}"></script>
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
                        <label for="filter-name">Package name:</label>
                        <input type="text" class="form-control" id="filter-name" name="name" placeholder="Search package by name">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Packages List</h3>
            <div class="block-options">
                <a href="{{ route('admin.packages.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new package</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-packages-list-table" data-url="{{ route('admin.packages.data') }}"></table>
        </div>
    </div>
@stop
