@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.transfer.index',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> Sealed bids ({{  $division->name }}) <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
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
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            @foreach($ownTeams as $team)
                                <a href="{{ route('manage.transfer.sealed.bid.bids',['division' => $division, 'team' => $team ]) }}" class="link-nostyle team-management-stepper">
                                    <div class="team-management-block has-icon">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $team->getCrestImageThumb() }}"  alt="">
                                        </div>
                                        <div class="team-detail-wrapper">
                                            <p class="team-title">{{ $team->name }}</p>
                                            <p class="team-owner text-dark">{{ $team->consumer->user->first_name }} {{ $team->consumer->user->last_name }} </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
