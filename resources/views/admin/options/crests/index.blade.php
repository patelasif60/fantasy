@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/options/crests/index.js') }}"></script>
@endpush

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Badges List</h3>
            <div class="block-options">
                <a href="{{ route('admin.options.crests.create') }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new badge</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-options-crests-list-table" data-url="{{ route('admin.options.crests.data') }}"></table>
        </div>
    </div>
@stop
