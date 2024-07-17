@extends('layouts.admin')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/admin/fixtures/index.js') }}"></script>
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
                            <label for="filter-season">Season:</label>
                            <select name="season" id="filter-season" class="form-control">
                                <option value=""></option>
                                @foreach($seasons as $id => $season)
                                    <option value="{{ $id }}">{{ $season }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="filter-competition">Competition:</label>
                            <select name="competition" id="filter-competition" class="form-control">
                                <option value=""></option>
                                @foreach($competitions as $competition)
                                    <option value="{{ $competition }}">{{ $competition }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="filter-home-club">Home Team:</label>
                            <select name="home_club" id="filter-home-club" class="form-control">
                                <option value=""></option>
                                @foreach($clubs as $id => $club)
                                    <option value="{{ $id }}">{{ $club }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="filter-away-club">Away Team:</label>
                            <select name="away_club" id="filter-away-club" class="form-control">
                                <option value=""></option>
                                @foreach($clubs as $id => $club)
                                    <option value="{{ $id }}">{{ $club }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 input-group">
                            <label for="filter-from-date">Date From:</label>
                            <div class="input-group">
                                <input type="text" 
                                class="form-control" 
                                id="filter-date-from" 
                                name="from_date_time" 
                                placeholder="Please select from date" 
                                data-date-format="{{config('fantasy.datetimepicker.format')}}"
                                autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label for="filter-from-date">Date To:</label>
                            <div class="input-group date">
                                <input type="text" 
                                class="form-control" 
                                id="filter-date-to" 
                                name="to_date_time" 
                                placeholder="Please select to date" 
                                data-date-format="{{config('fantasy.datetimepicker.format')}}"
                                data-week-start="1"
                                data-autoclose="true"
                                data-today-highlight="true"
                                autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </form>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Fixture List</h3>
            <div class="block-options">
                <a href="{{ route('admin.fixtures.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-5"></i>Add new fixture</a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-striped table-vcenter table-hover admin-fixtures-list-table" data-url="{{ route('admin.fixtures.data') }}"></table>
        </div>
    </div>
@stop
