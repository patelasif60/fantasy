@extends('layouts.manager')

@include('partials.manager.leagues')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/online_sealed_bid/teams.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.info',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li class="text-right">
                        {{-- <a href="{{ route('manage.more.division.index', ['division' => $division ]) }}">
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
    @if($round && $round->start <= now())
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="container-wrapper">
                    <div class="container-body">
                        @can('update', $division)
                            @if($endRound && $division->manual_bid == App\Enums\YesNoEnum::YES)
                                <div class="custom-alert alert-tertiary mt-3">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-dark">
                                        The {{ number_formatter_en_us($endRound->number) }} round deadline has passed.  The chairman is now able to process bids
                                    </div>
                                </div>
                                @if(! $division->is_round_process)
                                    <div class="text-center">
                                        <button data-link="{{ route('manage.auction.online.sealed.bid.process.start',['division' => $division ]) }}" data-round="{{ $endRound->number + 1 }}" class="btn btn-primary btn-sm js-process-bid-start">Process bids</button>
                                        <a href="{{ route('manage.division.auction.settings',['division' => $division ]) }}" class="btn btn-primary btn-sm ml-1">Change Deadline</a>
                                    </div>
                                @endif
                            @else
                                <div class="custom-alert alert-tertiary mt-3">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-dark">
                                        The {{ number_formatter_en_us($round->number) }} round is scheduled to end on {{ get_date_time_in_carbon($round->end)->format('jS M Y') }} at {{ get_date_time_in_carbon($round->end)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="text-center"><a href="{{ route('manage.division.auction.settings',['division' => $division ]) }}" class="btn btn-primary btn-sm">Change Deadline</a></div>
                            @endif
                        @else
                        <div class="custom-alert alert-tertiary mt-3">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                                @if(Carbon\Carbon::parse($round->end) <= now() && $nextRoundCount <= 0)
                                    The {{ number_formatter_en_us($endRound->number) }} round deadline has passed.  The chairman is now able to process bids
                                @else
                                   The {{ number_formatter_en_us($round->number) }} bidding round closes on {{ get_date_time_in_carbon($round->end)->format('jS M Y') }} at {{ get_date_time_in_carbon($round->end)->format('H:i') }}
                                @endif
                            </div>
                        </div>
                        @endcan

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-teams" data-url="{{ route('manage.auction.online.sealed.bid.teams.json',['division' => $division ]) }}"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="mb-5 mb-100 text-white">
                                @if($round)
                                    <p class="mt-5"> Your league auction is scheduled to begin on {{ get_date_time_in_carbon($round->start)->format('jS M Y') }} at {{ get_date_time_in_carbon($round->start)->format('H:i') }}. </p>
                                    <p> The {{ number_formatter_en_us($round->number) }} bidding round closes on {{ get_date_time_in_carbon($round->end)->format('jS M Y') }} at {{ get_date_time_in_carbon($round->end)->format('H:i') }}; please submit your first round bids by this time. </p>
                                    @can('update', $division)
                                        <p>You can change the dates of the {{ number_formatter_en_us($round->number) }} bidding
                                        round and schedule further bidding rounds
                                        if you wish.</p>
                                        <a href="{{ route('manage.division.auction.settings',['division' => $division ]) }}" class="btn btn-primary btn-lg btn-block">Schedule bidding rounds</a>
                                    @endcan
                                @else
                                    <p class="mt-5"> Your league auction starts but round not added. Please wait for the round. </p>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
