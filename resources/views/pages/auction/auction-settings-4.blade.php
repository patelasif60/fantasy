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
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction type</span>
                                            <span class="has-icon">Live online auction</span>
                                        </a>
                                    </div>
                                </li>
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction date</span>
                                            <span class="has-icon">31st July 2019</span>
                                        </a>
                                    </div>
                                </li>
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction budget</span>
                                            <span class="has-icon">£200m</span>
                                        </a>
                                    </div>
                                </li>
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction venue</span>
                                            <span class="has-icon">North Laine, Brighton</span>
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
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <span>Automatically process bids?</span>
                                        <span>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" checked=""  disabled="">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <label class="text-white list-group-title">Some help text here about auto processing bids.</label>

                            <ul class="custom-list-group list-group-white mb-4">
                                <li class="is-disabled">
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auctioneer</span>
                                            <span class="has-icon">Ben Grout (you)</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <span>Allow passing on nominations?</span>
                                        <span>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch3" checked="">
                                                <label class="custom-control-label" for="customSwitch3"></label>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Remote bidding time limit</span>
                                            <span class="has-icon">60 seconds</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>

                            <div class="mb-2"><button type="submit" class="btn btn-primary btn-block">Reset auction</button></div>
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



