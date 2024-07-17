@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <ul class="custom-list-group list-group-white mb-4">
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction type</span>
                                            <span class="has-icon">Online sealed bids</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper"><span class="has-icon">Auction date</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction budget</span>
                                            <span class="has-icon">£200m</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Bid increment</span>
                                            <span class="has-icon">£1m</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Rollover auction budget into season?</span>
                                        <span>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1"></label>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auctioneer</span>
                                            <span class="has-icon">Ben Grout (you)</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper"><span class="has-icon">Schedule bidding rounds</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Automatically process bids?</span>
                                        <span>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" checked="">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <p class="text-white">When enabled, round duration will default to 24 hours if rounds are not already scheduled</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
