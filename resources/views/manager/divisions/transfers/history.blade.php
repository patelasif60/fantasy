@extends('layouts.manager')

@push('header-content')
    {{-- @include('partials.auth.header') --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.transfer.index', ['division' => $division]) }}">
                            <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                        </a>
                    </li>
                    <li>Changes History</li>
                    <li>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fl fl-bar"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('plugin-styles')

    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')

    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>

@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/transfers/transfer_history.js') }}"></script>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                    <div class="container-body">
                        <div class="row mt-1">
                            <div class="col-12">

                                <form action="" method="POST" class="js-player-swap-form">
                                    <div class="row gutters-sm text-white">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="filter-type">Type:</label>
                                                <select name="type" id="filter-type" class="form-control js-select2">
                                                    <option value="">All</option>
                                                    @foreach($transferTypes as $id => $value)
                                                         <option value="{{ $id }}">{{ $value }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="filter-period">Period:</label>
                                                <select name="period" id="filter-period" class="form-control js-select2">
                                                    <option value="">All</option>
                                                    @foreach($periodEnum as $id => $value)
                                                         <option value="{{ $value }}">{{ $value }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <div class="table-responsive">
                                    <table class="table custom-table m-0 divison-transfer-history-table" data-url="{{ route('manage.division.transfer.history.list', ['division' => $division]) }}">

                                    </table>
                                </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
