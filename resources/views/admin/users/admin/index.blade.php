@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/users/admin/index.js') }}"></script>
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
                            <label for="filter-role">User type:</label>
                            <select name="role" id="filter-role" class="form-control">
                                <option value="">Select</option>
                                @foreach($roles as $key => $role)
                                    <option value="{{ $key }}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="filter-term">First name or Last name or Email address:</label>
                            <input type="text" class="form-control" id="filter-term" name="term" placeholder="Search term">
                        </div>
                    </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Admin User List</h3>
            <div class="block-options">
                <a href="{{ route('admin.users.admin.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new admin</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-users-list-table" data-url="{{ route('admin.users.admin.data') }}"></table>
        </div>
    </div>
@stop
