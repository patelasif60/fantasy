@extends('layouts.manager')

@include('partials.manager.leagues')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/sealed_bid_transfer/bids.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a @if(auth()->user()->consumer->ownTeam($division) > 1 || auth()->user()->consumer->ownTeam($division) === 0) href="{{ route('manage.transfer.sealed.bid.index',['division' => $division]) }}" @else href="{{ route('manage.transfer.index',['division' => $division]) }}" @endif><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> Sealed bids ({{  $team->name }}) <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li class="text-right">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button>
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
                        @if($round)
                            <div class="custom-alert alert-tertiary mt-3">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text text-dark">
                                    @if($isRoundProcessed)
                                        Round {{ $round->number }} is now complete.
                                    @else
                                        Deadline for Bid Round {{ $round->number }}  is {{ get_date_time_in_carbon($round->end)->format('jS M H:i') }} ({{ $sealedBidDeadLinesEnum[$division->getOptionValue('seal_bid_deadline_repeat')] }})
                                    @endif
                                </div>
                            </div>

                            @if($isRoundProcessed && !$division->is_round_process)
                                @can('ownLeagues',$division)
                                    <div class="text-center">
                                        <button class="btn btn-danger btn-sm btn-round-close">Close Round</button>
                                    </div>
                                @endcan

                                @can('ownTeam',$team)
                                    <h6 class="text-white text-center mt-3">Round {{ $round->number }} Results ({{ get_date_time_in_carbon($round->end)->format('d/m/y H:i') }})</h6>
                                @endcan
                            @else
                                <div class="text-center">
                                    @if(!$division->is_round_process)
                                        @can('ownLeagues',$division)
                                            @if(($endRound && Carbon\Carbon::parse($endRound->end)->lte(now())) )
                                                <button data-link="{{ route('manage.transfer.online.sealed.bid.process.start',['division' => $division]) }}" data-round="{{ $endRound->number + 1 }}" class="btn btn-danger btn-sm js-process-bid-start">Process bids</button>
                                            @endif
                                        @endcan
                                        @can('ownTeam',$team)
                                            <a href="{{ route('manage.transfer.sealed.bid.team',['division' => $division ,'team' => $team ]) }}" class="btn btn-primary btn-sm">Enter sealed bid</a>
                                        @endcan
                                    @endif
                                </div>
                                @can('ownTeam',$team)
                                    <h6 class="text-white text-center mt-3">Pending bids - Round {{ $round->number }}</h6>
                                @endcan
                            @endif
                            
                            
                            <div class="mt-3 mb-5 text-white">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-pending-bids" data-url="{{ route('manage.transfer.online.sealed.bid.teams.pending',['division' => $division, 'team' => $team ]) }}"></table>
                                </div>
                            </div>
                        @else
                            <div class="custom-alert alert-tertiary mt-3">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text text-dark">
                                    Sealed Bid Round not created yet. Please wait for chairman to create.
                                </div>
                            </div>
                        @endif

                        @if($processBidsCount)
                            <div class="mt-3 mb-5 text-white">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-process-bids" data-url="{{ route('manage.transfer.online.sealed.bid.teams.process',['division' => $division, 'team' => $team ]) }}"></table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection