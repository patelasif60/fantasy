@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/teams/team.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li><a href="{{ route('manage.transfer.index', ['division' => $division]) }}"><span><i class="fas fa-chevron-left pr-2"></i></span>Back</a></li>
                    <li>Team budgets</li>
                    <li><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"><span class="fl fl-bar"></span></button></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-md-10 col-lg-7">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="mt-3 text-white">
                     <form action="{{ route('manage.teams.budget.update',['division' => $division]) }}" encytype= "multipart/form-data" method="POST" class="js-division-update-form text-dark">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="js-table-division-teams-url" data-url="{{ route('manage.teams.budget.list',['division' => $division ]) }}">
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0 js-table-division-teams"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('ownLeagues', $division)
                           <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btnAdd">Update</button>
                                </div>
                            </div>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
