@extends('layouts.manager')
@include('partials.manager.leagues')
@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li class="text-left"></li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{ $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button> </li>
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
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.transfer.free_agents', ['division' => $division ]) }}" class="has-stepper">
                                            <span class="has-icon">Free Agents</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.teams.budget',['division' => $division]) }}#" class="has-stepper">
                                            <span class="has-icon">TEAM BUDGETS AND QUOTAS</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        @if(auth()->user()->consumer->ownTeam($division) > 1)
                                            <a href="{{ route('manage.transfer.sealed.bid.index',['division' => $division]) }}" class="has-stepper"> <span class="has-icon">Sealed Bids</span></a>
                                        @elseif (auth()->user()->consumer->ownTeam($division) === 0)
                                            <a href="{{ route('manage.transfer.sealed.bid.bids',['division' => $division ,'team' => $division->divisionTeams()->approve()->first() ]) }}" class="has-stepper"> <span class="has-icon">Sealed Bids</span></a>
                                        @else
                                            <a href="{{ route('manage.transfer.sealed.bid.bids',['division' => $division ,'team' => auth()->user()->consumer->ownTeamDetails($division) ]) }}" class="has-stepper"> <span class="has-icon">Sealed Bids</span></a>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.transfer.who_owns_who',['division' => $division]) }}" class="has-stepper">
                                            <span class="has-icon">Who Owns Who?</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.division.transfer.history', ['division' => $division ]) }}" class="has-stepper">
                                            <span class="has-icon">Changes History</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row pt-3">
                        @can('isTransferEnabled',$division)
                            @can('ownLeagues',$division)
                                <div class="col-md-6 mt-2">
                                    <a href="{{ route('manage.transfer.teams', ['division' => $division]) }}" class="btn btn-secondary btn-block">Transfer</a>
                                </div>
                            @else
                                @can('ownTeam', $division)
                                    <div class="col-md-6">
                                        <a href="{{ route('manage.transfer.transfer_players', ['division' => $division,'team' => auth()->user()->consumer->ownTeamDetails($division)]) }}" class="btn btn-secondary btn-block">Transfer</a>
                                    </div>
                                @endcan
                            @endcan
                        @endcan
                        <div class="col-md-6 mt-2">
                        @can('ownTeam', $division)
                            <a href="{{ route('manage.transfer.sealed.bid.team',['division' => $division ,'team' => auth()->user()->consumer->ownTeamDetails($division) ]) }}" class="btn btn-secondary btn-block">Enter sealed bid</a>
                        @endcan
                        @if(config('fantasy.swap_feature_live') == 'true' && $allowWeekendSwap)
                            @can('ownLeagues',$division)
                                <a href="{{ route('manage.transfer.swap', ['division' => $division]) }}" class="btn btn-secondary btn-block">SWAP DEALS</a>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
