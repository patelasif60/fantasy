@extends('layouts.manager')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li></li>
                    <li class="has-dropdown cursor-pointer"> {{ config('app.name') }}</li>
                    <li class="text-right"></li>
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
                            <ul class="custom-list-group list-group-white mb-4">
                                @can('update', $ownTeam)
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.teams.settings',['division' => $division, 'team' => $ownTeam]) }}" class="has-stepper">
                                            <span class="has-icon">Team Settings</span>
                                        </a>
                                    </div>
                                </li>
                                @endcan
                                @can('update', $division)
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.division.settings.edit',['name' => 'league', 'division' => $division ]) }}" class="has-stepper d-none d-md-block">
                                            <span class="has-icon">League Settings</span>
                                        </a>
                                        <a href="{{ route('manage.division.settings',['division' => $division ]) }}" class="has-stepper d-block d-md-none">
                                            <span class="has-icon">League settings</span>
                                        </a>
                                    </div>
                                </li>
                                @endcan
                                @if(Auth::user()->can('accessAuctionSettings', $division))
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.division.auction.settings',['division' => $division ]) }}" class="has-stepper">
                                            <span class="has-icon">Auction Settings</span>
                                        </a>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    <div class="list-element">
                                        <a href="@if(isset($division) && $division) {{ route('manage.division.createnew', ['division' => $division, 'from' => 'more']) }} @else {{ route('manage.division.create', ['from' => 'more' ]) }} @endif" class="has-stepper">
                                            <span class="has-icon">Create a New League</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.account.settings') }}" class="has-stepper">
                                            <span class="has-icon">My Account</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                            {{-- <label class="text-white list-group-title">Account and app</label> --}}
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('frontend.gameguide') }}" class="has-stepper" target="_blank">
                                            <span class="has-icon">Game Guide</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.division.auction.pdfdownloads',['division' => $division ]) }}" class="has-stepper">
                                            <span class="has-icon">Auction Pack</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.contactus') }}" class="has-stepper">
                                            <span class="has-icon">Contact Us</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="has-stepper">
                                            <span class="has-icon">{{ __('Logout') }}</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
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
