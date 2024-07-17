@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
@endpush

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                     <li>
                        <a href="{{ route('manage.division.info',['division' => $division ]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
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
@include('manager.divisions.preauction.links', ['division' => $division])
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">

                <div class="row">
                    <div class="col-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="league" role="tabpanel" aria-labelledby="league-tab">

                            @can('isPrivateLeague',$division)
                                <div class="custom-alert alert-tertiary">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-dark">
                                        @can('ownLeagues',$division)
                                            <div><a href="{{ route('manage.division.payment.index',['division' => $division,'type' => 'league']) }}">Click here</a>&nbsp;to pay for your team, remove teams or invite other managers.</div>
                                        @else
                                            <div><a href="{{ route('manage.division.payment.index',['division' => $division,'type' => 'league']) }}">Click here</a>&nbsp;to pay for your team or invite other managers.</div>
                                        @endcan
                                    </div>
                                </div>
                            @endcan

                            <ul class="custom-list-group list-group-white mb-5">
                                <li>
                                    <div class="list-element">
                                        <span>Auction Type</span>
                                        <span>@if($type)
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#AuctionTypeModal">
                                                <span>
                                                    {{-- <img src="{{asset('assets/frontend/img/auction/icon-information.png')}}" alt="information-icon" draggable="false"> --}}
                                                    <i class="fl fl-info"></i>
                                                </span>
                                            </a>
                                            {{$type}}
                                         @else TBC @endif</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Start Time</span>
                                        <span>@if($startTime) {{ get_date_time_in_carbon($startTime)->format(config('fantasy.view.day_month_year_time')) }} @else TBC @endif</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Venue</span>
                                        <span>@if($venue) {{$venue}} @else TBC @endif</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Budget</span>
                                        <span>@if($budget) £{{$budget}}m @else TBC @endif</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Bid Increment</span>
                                        <span>@if($bidIncrement) £{{$bidIncrement}}m @else TBC @endif</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Budget Rollover</span>
                                        <span class="f12">{{ $budgetRollover }}</span>
                                    </div>
                                </li>
                                @if($type == $auctionTypesEnum['ONLINE_SEALED_BIDS_AUCTION'])
                                    <li>
                                        <div class="list-element">
                                            <span>Tie Break preference</span>
                                            <span class="f12">@if($tiePreference) {{$tiePreferenceEnum[$tiePreference]}} @else TBC @endif</span>
                                        </div>
                                    </li>

                                    @if($auctionRounds)
                                        @foreach($auctionRounds as $rounds)
                                            <li>
                                                <div class="list-element">
                                                    <span>Round {{$rounds->number}}</span>
                                                    <span class="f12">{{ get_date_time_in_carbon($rounds->end)->format(config('fantasy.view.day_month_year_time')) }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                @endif
                                @if($type == $auctionTypesEnum['LIVE_ONLINE_AUCTION'])
                                    <li>
                                        <div class="list-element">
                                            <span>Passing On Nominations</span>
                                            <span class="f12">@if($isOnNominations) Yes @else No @endif</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <span>Remote Nomination Time Limit</span>
                                            <span class="f12">@if($nominationLimit) {{$nominationLimit}} seconds @else TBC @endif</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <span>Remote Bids Time Limit</span>
                                            <span class="f12">@if($bidsLimit) {{$bidsLimit}} seconds @else TBC @endif</span>
                                        </div>
                                    </li>
                                 @endif
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="AuctionTypeModal" tabindex="-1" role="dialog" aria-labelledby="AuctionTypeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">{{$type}} auction</h5>
            </div>
            <div class="modal-body">
                <p>
                    <!-- to be reverted when dynamic data via CMS is implemented -->
                    Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi quis iaculis nulla iaculis vitae. Donec sagittis faucibus lacus eget blandit. Mauris vitae ultricies metus, at condimentum nulla. Donec quis ornare lacus. Etiam gravida mollis tortor quis porttitor.
                </p>
            </div>
        </div>
    </div>
</div>
@endpush
