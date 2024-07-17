@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/transfers/who_owns_who.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.transfer.index', ['division' => $division]) }}">
                            <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                        </a>
                    </li>
                    <li>Who owns who?</li>
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

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
            	<div class="mt-3 text-white">
                	<form action="#" class="js-player-filter-form" method="POST">
					    <div class="block">
					        <div class="block-content block-content-full">
				                <div class="form-group row">
				                    <div class="col-6">
				                        <label for="filter-position">Position:</label>
				                        <select name="position" id="filter-position" class="form-control js-player-filter-form js-select2">
				                            <option value="">All</option>
                                                @foreach($positions as $id => $type)
                                                     <option value="{{ $id }}">{{ player_position_except_code($id) }}s ({{ $division->getPositionShortCode(player_position_short($id))  }})</option>
                                                @endforeach
				                        </select>
				                    </div>
				                    <div class="col-6">
				                        <label for="filter-club">Club:</label>
				                        <select name="club" id="filter-club" class="form-control js-player-filter-form js-select2">
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
                    <div class="table-responsive">
                        <table class="table text-center custom-table js-table-filter-who-owns-who-players" data-url="{{ route('manage.transfer.get.who_owns_who', ['division' => $division]) }}">
                        </table>
                    </div>
                </div>
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
@endsection
