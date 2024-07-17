@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/join_league.js') }}"></script>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ route('manage.division.join.league.select') }}">
                                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                        </a>
                                    </li>
                                    <li class="text-center">Join a Social League</li>
                                    <li class="text-right">
                                        @include('partials.manager.more_menu')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="auth-card-content-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-lg-8 col-xl-8">
                                <div class="container-wrapper">
                                    <div class="container-body">
                                        <div class="row mt-1">
                                            <div class="col-12">
                                                 <div class="custom-alert alert-danger">
                                                    <div class="alert-text">
                                                        You already have a team in this Social League
                                                    </div>
                                                </div>
                                                <p class="text-white">Click on another league to join.</p>
                                                @foreach($divisions as $division)
                                                    <div class="cta-block-stepper">
                                                        <a href="javascript:void(0);" class="join_league" data-via="social" data-division-id="{{$division->id}}">{{$division->name}}</a>
                                                        <p>{{$division->team_count}} {{$division->team_count == 1 ? 'team' : 'teams'}} in league, @if($division->team_count < $division->maximum_teams){{$division->maximum_teams - $division->team_count}} @else 0 @endif places remaining</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
