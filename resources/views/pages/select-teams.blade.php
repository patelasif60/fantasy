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
                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper">
                                        <p class="team-title">
                                            Ben Grout <span class="font-weight-normal small pl-1">Citizen Kane</span>
                                        </p>
                                        <p class="team-amount text-dark mb-0">£30 outstanding</p>
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
                                    <div class="team-detail-wrapper">
                                        <p class="team-title">
                                            Richard Stenson <span class="font-weight-normal small pl-1">Richard’s Team</span>
                                        </p>
                                        <p class="team-amount text-dark mb-0">£30 outstanding</p>
                                    </div>
                                    <div class="team-selection-payment">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="team-richard">
                                            <label class="custom-control-label" for="team-richard"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper">
                                        <p class="team-title">
                                            Stuart Walsh <span class="font-weight-normal small pl-1">Untapped Talent</span>
                                        </p>
                                        <p class="paid-team text-dark mb-0">
                                            Paid <span class="ml-1"><i class="fas fa-check-circle"></i></span>
                                        </p>
                                    </div>
                                    <div class="team-selection-payment"></div>
                                </div>
                            </div>

                            <div class="team-management-stepper team-payment-block">
                                <div class="team-management-block">
                                    <div class="team-detail-wrapper">
                                        <p class="team-title">
                                            Chris Cragg <span class="font-weight-normal small pl-1">Oh Not Again</span>
                                        </p>
                                        <p class="paid-team text-dark mb-0">
                                            Paid <span class="ml-1"><i class="fas fa-check-circle"></i></span>
                                        </p>
                                    </div>
                                    <div class="team-selection-payment"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Checkout</button>
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
