@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/divisions/subdivison.js') }}"></script>
@endpush

@section('content')
    <form action="#" class="js-filter-form" method="POST">
        <div class="block">
            <input type="hidden" class="form-control" id="filter-division_id" name="division_id" value={{$division->id}}>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Division List</h3>
            <div class="block-options">
                <a href="{{ route('admin.divisions.create', ['division' => $division->id]) }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new division</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-sub-divisions-list-table" data-url="{{ route('admin.divisions.subdivison.data') }}"></table>
        </div>
    </div>
@stop



