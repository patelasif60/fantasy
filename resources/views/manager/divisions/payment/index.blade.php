@extends('layouts.manager')

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/payment/team_selection.js')}}"></script>
@endpush

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li> <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button> </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center no-gutters">
    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
        <div class="container-wrapper">
            <div class="container-body mb-3">
                @include('manager.divisions.preauction.links', ['division' => $division])
                <div>
                    @if($division->divisionTeams()->approve()->count() > 0)
                        @if($user->can('ownLeagues', $division) && $teamApprovals->count() > 0)
                            <div class="row justify-content-center">
                                <div class="col-12 mt-4">
                                    <div class="custom-alert alert-tertiary">
                                        <div class="alert-icon"><img src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img"></div>
                                        <div class="alert-text text-dark">
                                            <span class="has-icon">A new manager has requested to join your league</span>&nbsp;<a href="{{route('manage.division.team.approvals', ['division' => $division])}}" class="has-stepper">Click here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="auction-listing">
                                    <div class="auction-list-group">
                                        @foreach($allTeams as $divTeam)
                                            @if($divTeam->team->isPaid() === true)
                                                <div class="auction-list-group-item">
                                                    <div class="auction-items">
                                                        <div class="item">
                                                            <div class="league-crest">
                                                                <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $divTeam->team->getCrestImageThumb() }}"  alt="{{ $divTeam->team->name }}\'s Badge">
                                                            </div>
                                                            <div>
                                                                @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                    <a class="team-name" href="{{ route('manage.teams.settings',['division' => $division, 'team'=> $divTeam->team->id]) }}">{{ $divTeam->team->name }}</a>
                                                                @else
                                                                    <div class="team-name">{{ $divTeam->team->name }}</div>
                                                                @endcan
                                                                <div class="owner-name">{{ $divTeam->team->consumer->user->first_name }} {{ $divTeam->team->consumer->user->last_name }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <div class="status is-paid">
                                                                @if($division->package->private_league=='Yes')
                                                                    <span><i class="fas fa-check-circle"></i></span>
                                                                    <span class="status-text">Paid</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($divTeam->team->isPaid() == 'strike')
                                                @if($division->getPrize() > 0)
                                                    <div class="auction-list-group-item">
                                                        <div class="auction-items">
                                                            <div class="item">
                                                                <div class="league-crest">
                                                                    <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $divTeam->team->getCrestImageThumb() }}"  alt="{{ $divTeam->team->name }}\'s Badge">
                                                                </div>
                                                                <div>
                                                                    @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                        <a class="team-name" href="{{ route('manage.teams.settings',['division' => $division, 'team'=>$divTeam->team->id]) }}">{{$divTeam->team->name }} </a>
                                                                    @else
                                                                        <div class="team-name">{{ $divTeam->team->name }}</div>
                                                                    @endcan
                                                                    <div class="owner-name">{{ $divTeam->team->consumer->user->first_name }} {{ $divTeam->team->consumer->user->last_name }} </div>
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                @if($division->package->private_league == 'Yes')
                                                                    <form class="mt-0" action="{{ route('manage.division.payment.teams', ['division' => request('division')]) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$divTeam->team->id}}" id="teamId" name="teamId">
                                                                        @if($division->package->private_league == 'Yes')
                                                                            @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                                <a href="{{ route('manage.teams.payment.remove', ['team' => $divTeam->team->id]) }}" title="Delete" class="status is-delete delete-confirmation-button"> <span><i class="fa fa-trash"></i></span> <span class="status-text">Delete</span> </a>
                                                                            @endcan
                                                                        @endif
                                                                        <button type="submit" class="status is-unpaid">
                                                                            <span><i class="fas fa-exclamation-circle"></i></span>
                                                                            <span class="status-text">£ {{ $division->getPrize()}} <span class="d-none d-md-inline-block">Outstanding</span></span>
                                                                        </button>
                                                                        <div class="status is-paid is-strike">
                                                                            <span><i class="fas fa-check-circle"></i></span>
                                                                            <span class="status-text"><strike>£ {{$price - $division->getPrize() }}</strike> <span class="d-none d-md-inline-block">Free</span></span>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="auction-list-group-item">
                                                        <div class="auction-items">
                                                            <div class="item">
                                                                <div class="league-crest">
                                                                    <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $divTeam->team->getCrestImageThumb() }}"  alt="{{$divTeam->team->name }}\'s Badge">
                                                                </div>
                                                                <div>
                                                                    @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                        <a class="team-name" href="{{ route('manage.teams.settings',['division' => $division, 'team'=>$divTeam->team->id]) }}">{{$divTeam->team->name }}</a>
                                                                    @else
                                                                        <div class="team-name">{{$divTeam->team->name }}</div>
                                                                    @endcan
                                                                    <div class="owner-name">{{ $divTeam->team->consumer->user->first_name }} {{ $divTeam->team->consumer->user->last_name }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                @if($division->package->private_league == 'Yes')
                                                                    @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                        <a href="{{ route('manage.teams.payment.remove', ['team' => $divTeam->team->id]) }}" title="Delete" class="status is-delete delete-confirmation-button"> <span><i class="fa fa-trash"></i></span> <span class="status-text">Delete</span> </a>
                                                                    @endcan
                                                                <div class="status is-paid  is-strike">
                                                                    <span><i class="fas fa-check-circle"></i></span>
                                                                    <span class="status-text"><strike>£ {{$price - $division->getPrize() }}</strike> <span class="d-none d-md-inline-block">Free</span></span>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="auction-list-group-item">
                                                    <div class="auction-items">
                                                        <div class="item">
                                                            <div class="league-crest">
                                                                <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="{{ $divTeam->team->getCrestImageThumb() }}"  alt="{{$divTeam->team->name }}\'s Badge">
                                                            </div>
                                                            <div>
                                                                @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                    <a class="team-name" href="{{ route('manage.teams.settings',['division' => $division, 'team'=>$divTeam->team->id]) }}">{{$divTeam->team->name }}</a>
                                                                @else
                                                                    <div class="team-name">{{ $divTeam->team->name }}</div>
                                                                @endcan
                                                                <div class="owner-name">{{ $divTeam->team->consumer->user->first_name }} {{ $divTeam->team->consumer->user->last_name }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            @if($division->package->private_league == 'Yes')
                                                            <form class="mt-0" action="{{ route('manage.division.payment.teams', ['division' => request('division')]) }}" method="POST" >
                                                                @csrf
                                                                @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                    <a href="{{ route('manage.teams.payment.remove', ['team' => $divTeam->team->id]) }}" title="Delete" class="delete-confirmation-button status is-delete"> <span><i class="fa fa-trash mr-2"></i></span> <span class="status-text">Delete</span> </a>
                                                                @endcan
                                                                <input type="hidden" value="{{$divTeam->team->id}}" id="teamId" name="teamId">
                                                                @can('isChairmanOrManager', [$division, $divTeam->team])
                                                                    <button type="submit" class="status is-unpaid"> <span><i class="fas fa-exclamation-circle"></i></span> <span class="status-text">£ {{$price}} <span class="d-none d-md-inline-block">Outstanding</span></span> </button>
                                                                @else
                                                                    <button type="button" class="status is-unpaid"> <span><i class="fas fa-exclamation-circle"></i></span> <span class="status-text">£ {{$price}} <span class="d-none d-md-inline-block">Outstanding</span></span> </button>
                                                                @endcan
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="custom-alert alert-danger text-dark m-4">
                                    <div class="alert-icon"> <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img"> </div>
                                    <div class="alert-text text-dark">No teams added to {{$division->name}} yet.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection