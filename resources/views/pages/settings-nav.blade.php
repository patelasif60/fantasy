@extends('layouts.auth.redesign')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-navigation-bar">
                    <div class="row align-items-center no-gutters">
                        <div class="col-md-4 col-lg-3">
                            <ul class="top-navigation-bar">
                                <li>
                                    <a href="javascript:void(0);" onclick="javascript:history.back();">
                                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                    </a>
                                </li>
                                <li class="text-center">Settings</li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="col-md-8 col-lg-9 d-none d-md-block">
                            <div class="text-white text-center">Team Settings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1 no-gutters">
                        <div class="col-md-4 col-lg-3">
                            <div class="left-side-navigation h-100">
                                <ul class="custom-list-group list-group-white mb-4">
                                    <li>
                                        <div class="list-element">
                                            <a href="#"><span>Team Settings</span></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#"><span>My Account</span></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#"><span>App Settings</span></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <div class="right-side-navigation px-0 px-md-4">
                                <ul class="custom-list-group list-group-white mb-4">
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper has-text">
                                                <span>League Name</span>
                                                <span class="has-icon">Magnificent 7</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper has-text">
                                                <span>Package</span>
                                                <span class="has-icon">Legend</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper"><span class="has-icon">Chief Execs</span></a>
                                        </div>
                                    </li>
                                </ul>

                                <label class="text-white list-group-title">Lorem Ipsum Dolor</label>

                                <ul class="custom-list-group list-group-white mb-4">
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper has-text">
                                                <span>Auction Type</span>
                                                <span class="has-icon">Real time</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper has-text">
                                                <span>Pre-season auction budget</span>
                                                <span class="has-icon">£200m</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <span>Rollover budget into season?</span>
                                            <span>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="">
                                                    <label class="custom-control-label" for="customSwitch1"></label>
                                                </div>
                                            </span>
                                        </div>
                                    </li>
                                </ul>

                                <label class="text-white list-group-title">Donec fermentum lorem</label>

                                <ul class="custom-list-group list-group-white mb-3">
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper"><span class="has-icon verified-data">Etiam Quis Porta</span></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <span>Nullam Turpis</span>
                                            <span>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2"></label>
                                                </div>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-element">
                                            <a href="#" class="has-stepper"><span class="has-icon verified-data">Cras Pulvinar</span></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
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


