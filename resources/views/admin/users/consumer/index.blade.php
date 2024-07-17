@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/users/consumer/index.js') }}"></script>
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
                <div class="form-group">
                    <label for="filter-term">First name or Last name or email address:</label>
                    <input type="text" class="form-control" id="filter-term" name="term" placeholder="Search term">
                </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Consumer User List</h3>
            <div class="block-options">
                <a href="{{ route('admin.users.consumers.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new consumer</a>
                <a href="" class="btn btn-outline-primary exportCsv"><i class="fa fa-plus mr-5"></i>Export to CSV</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover consumer-users-list-table" data-url="{{ route('admin.users.consumers.data') }}"></table>
        </div>
    </div>
@stop
