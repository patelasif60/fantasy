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

                            <p class="text-white">Select all managers that will be participating
                            in the auction remotely. Remote participants
                            must be online for the duration of the
                            auction.</p>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper d-flex align-items-center">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/league/league.svg')}}" data-src="{{ asset('assets/frontend/img/league/league.svg')}}" alt="Team Crest" draggable="false">
                                        </div>
                                        <div class="ml-2">
                                            <p class="team-title">
                                                Citizen Kane
                                            </p>
                                            <p class="team-amount text-dark mb-0">Ben Grout</p>
                                        </div>
                                    </div>
                                    <div class="team-selection-payment">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="team-ben">
                                            <label class="custom-control-label" for="team-ben"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper d-flex align-items-center">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/league/league.svg')}}" data-src="{{ asset('assets/frontend/img/league/league.svg')}}" alt="Team Crest" draggable="false">
                                        </div>
                                        <div class="ml-2">
                                            <p class="team-title">
                                                Oh Not Again
                                            </p>
                                            <p class="team-amount text-dark mb-0">Chris Cragg</p>
                                        </div>
                                    </div>
                                    <div class="team-selection-payment">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="team-chris">
                                            <label class="custom-control-label" for="team-chris"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper d-flex align-items-center">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/league/league.svg')}}" data-src="{{ asset('assets/frontend/img/league/league.svg')}}" alt="Team Crest" draggable="false">
                                        </div>
                                        <div class="ml-2">
                                            <p class="team-title">
                                                Untappedtalent United
                                            </p>
                                            <p class="team-amount text-dark mb-0">Stuart Walsh</p>
                                        </div>
                                    </div>
                                    <div class="team-selection-payment">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="team-walsh" checked="">
                                            <label class="custom-control-label" for="team-walsh"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper d-flex align-items-center">
                                        <div class="team-crest-wrapper">
                                            <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/league/league.svg')}}" data-src="{{ asset('assets/frontend/img/league/league.svg')}}" alt="Team Crest" draggable="false">
                                        </div>
                                        <div class="ml-2">
                                            <p class="team-title">
                                                Richard's Team
                                            </p>
                                            <p class="team-amount text-dark mb-0">Richard Stenson</p>
                                        </div>
                                    </div>
                                    <div class="team-selection-payment">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="team-richard" checked="">
                                            <label class="custom-control-label" for="team-richard"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2"><button type="submit" class="btn btn-primary btn-block">Next</button></div>
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
