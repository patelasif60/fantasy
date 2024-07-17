@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">

            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li><a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a></li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"><span class="fl fl-bar"></span></button></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
   <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            @include('manager.divisions.preauction.links', ['division' => $division, 'page' => 'team'])
        </div>
    </div>
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-alert alert-tertiary" role = "alert">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text text-dark">
                                    @can('accessPaidTeams', $division)
                                        @if($division->package->private_league == 'Yes')
                                            Once you have completed the auction, you will have access to your team.
                                        @else
                                        Once there are more than five paid teams in this league your online sealed bids auction will commence at 12:00 UK time on Friday. The first round bid deadline will be 12:00 UK time the following Monday (allowing you 72 hours to place your first round bids), with bidding rounds every 24 hours thereafter until the auction is complete – which usually takes four or five rounds. We will notify you when the auction is live.
                                        @endif
                                    @elsecan('ownTeamInParentAssociatedLeague', $division)
                                        You do not currently have a team in this division. Please navigate to your own division via the top navigation before selecting TEAM.
                                    @else
                                        Once all teams have paid and your auction is complete, you will have access to your team.
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
