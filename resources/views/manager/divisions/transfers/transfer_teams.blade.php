@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">

            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.transfer.index', ['division' => $division]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li>{{  $division->name }}</li>
                    <li class="text-right">
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
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                   <div class="row">
                        <div class="col-12 text-white">
                            @foreach($teams as $team)
                               <a href="{{ route('manage.transfer.transfer_players',['division' => $division, 'team' => $team ]) }}" class="link-nostyle team-management-stepper mt-3 mb-3">
                                    <div class="team-management-block has-icon">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $team->getCrestImageThumb() }}"  alt="Team Badge">
                                        </div>
                                        <div class="team-detail-wrapper">
                                            <p class="team-title">{{ $team->name }}</p>
                                            <p class="team-owner text-dark">{{ $team->consumer->user->first_name }} {{ $team->consumer->user->last_name }}</p>
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