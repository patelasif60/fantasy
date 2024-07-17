@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center no-gutters">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="cta-block-preauction-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-9">
                                <div class="cta-block-preauction">
                                    <div class="league-image">
                                        <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-blue-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-blue.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-blue.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-blue@2x.png')}} 2x" alt="">
                                    </div>
                                    <div class="cta-wrapper">
                                        <div class="cta-detail">
                                            <p class="cta-title">Legend league</p>
                                            <div class="cta-link">
                                                <a href="">League rules</a>
                                            </div>
                                        </div>
                                        <div class="cta-add-friend text-center">
                                            <div class="cta-link">
                                                <a href="#">
                                                    <div class="icon-add">
                                                        <img src="{{ asset('assets/frontend/img/auction/add-user.svg')}}" alt="add-icon">
                                                    </div>
                                                    Invite friend
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-12 col-md-9">
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Auction Type</span>
                                            <span><img src="{{ asset('assets/frontend/img/auction/icon-information.png')}}" alt="information-icon"> Live online</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Start time</span>
                                            <span>TBC</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Venue</span>
                                            <span>TBC</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Budget</span>
                                            <span>£200m</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Bid increment</span>
                                            <span>£0.5m</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Passing on nominations</span>
                                            <span>Allowed</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Remote nomination time limit</span>
                                            <span>60s</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Remote bids time limit</span>
                                            <span>60s</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
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

@stack('page-scripts')


