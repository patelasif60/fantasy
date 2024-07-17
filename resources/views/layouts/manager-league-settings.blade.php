@extends('layouts.manager-settings')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-navigation-bar">
                    <div class="row align-items-center no-gutters">
                        <div class="col-md-4 col-lg-3">
                            <ul class="top-navigation-bar">
                                <li>
                                    <a href="{{ route('manage.division.settings', ['division' => $division ]) }}" class="d-block d-md-none"><span><i class="fas fa-chevron-left pr-2"></i></span>Back</a>
                                    <a href="{{ route('manage.division.info', ['division' => $division ]) }}" class="d-none d-md-block"><span><i class="fas fa-chevron-left pr-2"></i></span>Back</a>
                                </li>
                                <li class="text-center">Settings</li>
                                <li>
                                    <div class="d-md-none">@yield('page-action', '')</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8 col-lg-9 d-none d-md-block">
                            <ul class="px-md-4 top-navigation-bar">
                                <li></li>
                                <li>@yield('page-name', 'League Settings')</li>
                                <li>@yield('page-action')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('left')
	<ul class="custom-list-group list-group-white mb-4">
        <li class="@can('packageDisabled', $division) is-disabled @endcan">
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'package' ]) }}" class="has-stepper"><span class="has-icon">Package</span></a>
            </div>
        </li>
        @can('accessAuctionSettings', $division)
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.auction.settings',['division' => $division]) }}" class="has-stepper"><span class="has-icon">Auction</span></a>
            </div>
        </li>
        @endcan
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'league' ]) }}" class="has-stepper"><span class="has-icon">League</span></a>
            </div>
        </li>
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'squad_and_formations' ]) }}" class="has-stepper"><span class="has-icon">Squad and Formations</span></a>
            </div>
        </li>
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'points_setting' ]) }}" class="has-stepper"><span class="has-icon">Scoring System</span></a>
            </div>
        </li>
        @can('isPostAuctionState', $division)
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'transfer' ]) }}" class="has-stepper"><span class="has-icon">Transfers and Sealed Bids</span></a>
            </div>
        </li>
        @endcan
        @can('allowCustomCup', $division)
            <li>
                <div class="list-element">
                    <a href="{{ route('manage.division.custom.cups.index',['division' => $division]) }}" class="has-stepper"><span class="has-icon">Custom Cups</span></a>
                </div>
            </li>
        @endcan
        @can('isEuropeanTournamentAvailable', $division)
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'european_cups' ]) }}" class="has-stepper"><span class="has-icon">European Competitions</span></a>
            </div>
        </li>
        @endcan
        <li>
            <div class="list-element">
                <a href="{{ route('manage.division.history.index',['division' => $division]) }}" class="has-stepper"><span class="has-icon">Hall of Fame</span></a>
            </div>
        </li>
    </ul>
@endsection
