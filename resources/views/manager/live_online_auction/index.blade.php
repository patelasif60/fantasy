@extends('layouts.manager')

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
                        @if(auth()->user()->consumer->ownLeagues($division))
                        <a href="{{ route('manage.division.settings',['division' => $division ]) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                        @endif
                    </li>
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
                    <div class="row mt-1">
                        <div class="col-12">
                            <p class="text-white">Your league auction is scheduled to begin on {{carbon_format_view_date($division->auction_date)}}.</p>
                            <p class="text-white">The auction format is Live Online. You are nominated as the auctioneer.</p>
                            <p class="text-white">Once the auction is completed you will be able to manage your team.</p>
                        </div>
                    </div>
                </div>

                @can('ownLeagues', $division)
                    @if($division->isAuctionSet() && $division->isInAuctionState())
                        <div class="container-body">
                            <div class="mb-2">
                                <a href="{{route('manage.live.online.auction.start', ['division' => $division])}}" class="btn btn-primary btn-block">Start auction now</a>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>

@endsection