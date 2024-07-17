@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <style type="text/css">
        .manager-teams-list-table tbody .text-right-padding {
            padding-right: 20px !important;
        }
    </style>
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/more/players.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.stat.index',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                </li>
                <li> Player List </li>
                <li>
                    {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#PrintableListModal"><i class="fas fa-print fa-lg mr-2"></i></a> --}}
                    {{-- <a class="ml-3" href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
                        <span><i class="fas fa-bars"></i></span>
                    </a> --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fl fl-bar"></span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="row justify-content-end mb-3">
                    <div class="col-md-5 col-lg-4">
                        <button type="button" data-toggle="modal" data-target="#PrintableListModal" class="btn btn-secondary btn-block"><i class="fas fa-file-download mr-2"></i>Download player list</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-white">
						<form action="#" class="js-player-filter-form" method="POST">
						    <div class="block">
						        <div class="block-content block-content-full">
					                <div class="form-group row">
					                    <div class="col-6">
					                        <label for="filter-position">Position:</label>
					                        <select name="position" id="filter-position" class="form-control js-select2">
					                            <option value="">All</option>
					                            @foreach($positions as $id => $type)
					                                 <option value="{{ $id }}">{{ player_position_except_code($id) }}s ({{ $division->getPositionShortCode(player_position_short($id))  }})</option>
					                            @endforeach
					                        </select>
					                    </div>
					                    <div class="col-6">
					                        <label for="filter-club">Club:</label>
					                        <select name="club" id="filter-club" class="form-control js-select2">
					                            <option value="">All</option>
					                            @foreach($clubs as $id => $club){
					                                 <option value="{{ $club->id }}">{{ $club->name }}</option>
					                            @endforeach
					                        </select>
					                    </div>
					                </div>
						        </div>
						    </div>
						</form>
						<table class="table custom-table manager-teams-list-table mt-100" data-url="{{ route('manage.more.players.data',['division' => $division]) }}"></table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="PrintableListModal" tabindex="-1" role="dialog" aria-labelledby="PrintableListModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Printable player list</h5>
            </div>
            <div class="modal-body">
                <p>
                    You can download a copy of the player list in PDF or Excel format
                </p>
                <p class='printable-links'><a href="{{route('manage.more.players.export_pdf',['division' => $division])}}">Download Excel</a><br><a href="{{route('manage.more.players.export_xlsx',['division' => $division])}}">Download PDF</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="js_player_details_modal" data-url="{{ route('manage.more.players.data.details',['division' => $division]) }}" role="dialog" aria-labelledby="PrintableListModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h3 class="modal-title js-player-name"></h3>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@endpush
