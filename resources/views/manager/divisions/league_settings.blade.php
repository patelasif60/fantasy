@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li> <a href="{{ url()->previous() }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
