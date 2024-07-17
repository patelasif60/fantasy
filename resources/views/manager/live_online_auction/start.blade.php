@extends('layouts.manager')

@push('plugin-styles')
    <script type="text/javascript" src="{{ asset('/js/plugins/datatables/datatables.min.css') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/lonauction/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
@endpush

@push('header-content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.info', ['division' => $division]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li>{{$division->name}}</li>
                    <li>
                        @can('ownLeagues', $division)
                            <a href="{{ route('manage.division.settings',['division' => $division ]) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                        @endcan
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center" id="lonauction">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">

                            @can('ownLeagues', $division)
                                <onlineauction
                                :start-auction-time="{{ json_encode(carbon_format_view_date($division->auction_date)) }}"
                                :is-auction-set="{{ json_encode($division->isAuctionSet()) }}"  :is-in-auction-state="{{ json_encode($division->isInAuctionState()) }}" :team-managers="{{$teamManagers}}"
                                :user-role="'auctiontioneer'"
                                :division="{{$division->id}}"
                                :team-details="{{ json_encode(auth()->user()->consumer->ownTeamDetails($division)) }}"
                                :clubs="{{json_encode($clubs)}}"
                                :positions="{{json_encode($positions)}}"
                                :players="{{json_encode($players)}}"
                                :max-club-players="{{ json_encode($maxClubPlayer) }}"
                                :squad-size="{{ json_encode($defaultSquadSize) }}"
                                :is-close-auction="{{ json_encode($division->allOnlineAuctionTeamsSquadFull()) }}">
                                </onlineauction>
                            @else
                                <onlineauction
                                :start-auction-time="{{ json_encode(carbon_format_view_date($division->auction_date)) }}"
                                :is-auction-set="{{ json_encode($division->isAuctionSet()) }}"  :is-in-auction-state="{{ json_encode($division->isInAuctionState()) }}" :team-managers="{{$teamManagers}}"
                                :user-role="'manager'"
                                :division="{{$division->id}}"
                                :team-details="{{ json_encode(auth()->user()->consumer->ownTeamDetails($division)) }}"
                                :clubs="{{json_encode($clubs)}}"
                                :positions="{{json_encode($positions)}}"
                                :players="{{json_encode($players)}}"
                                :max-club-players="{{ json_encode($maxClubPlayer) }}"
                                :squad-size="{{ json_encode($defaultSquadSize) }}"
                                :is-close-auction="{{ json_encode($division->allOnlineAuctionTeamsSquadFull()) }}">
                                </onlineauction>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
