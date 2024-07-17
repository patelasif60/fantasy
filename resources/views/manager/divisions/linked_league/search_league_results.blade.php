@extends('layouts.manager')

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.linked.league.search',['division' => $division]) }}">
                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                    </a>
                </li>
                <li class="text-center">Matching Leagues</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-8">
                <div class="container-wrapper">
                    <div class="container-body">
                        @if(count($allLeagues) == 0)
                                <div class="custom-alert alert-danger text-dark text-center justify">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                             There are no leagues that match this description. Please try again.
                            </div>
                        </div>
                            @endif
                        <div class="row mt-1">
                            <div class="col-12">
                                @foreach($allLeagues as $league)
                                    <a href="{{route('manage.linked.league.select.league', ['division' => $division, 'league' => $league->id])}}" class="join_league cta-block-stepper-options link-nostyle team-management-stepper mb-3">
                                        <div class="team-management-block has-icon">
                                            {{$league->name}}
                                        </div>
                                        <p class="mt-0">Chairman: {{$league->consumer->user->first_name . ' ' . $league->consumer->user->last_name}}<br>
                                            {{mb_strimwidth($league->introduction, 0, 100, '...')}}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
