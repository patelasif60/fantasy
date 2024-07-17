@extends('layouts.manager')

@push('header-content')
    {{-- @include('partials.auth.header') --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center">all done</li>
                    <li class="text-right"></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('page-analytics')
    @include('partials.facebook_reg_pixel')
    @include('partials.twitter_reg_pixel')
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    {{-- <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li></li>
                                    <li class="text-center">You’re Ready</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-xl-8">
                                <div class="complete-registration text-center">
                                    {{-- <img src="{{ asset('assets/frontend/img/ball.svg')}}" alt="" class="img-ball"> --}}
                                    <div class="img-whistle mb-3"><i class="fl fl-whistle-cirlcle"></i></div>
                                    <h4 class="font-weight-bold">Ready to Kick-Off!</h4>
                                    <p><b>Congratulations!</b> You’ve successfully joined Fantasy League. Click the button below to go to your league and start preparing for your auction.</p>

                                    {{-- <div class="row justify-content-center mt-4">
                                        <div class="col-md-9">
                                            <div class="row gutters-md">
                                                <div class="col-6">
                                                    <a href="#">
                                                        <img src="{{ asset('assets/frontend/img/app-store.png')}}" class="img-fluid" alt="App Store">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="#">
                                                        <img src="{{ asset('assets/frontend/img/google-play.png')}}" class="img-fluid" alt="Google Play">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row justify-content-center mt-5">
                                    <div class="col-md-9">
                                        <a href="{{ auth()->user()->can('ownLeagues',$division)? $division->is_viewed_package_selection == 0 ? route('manage.division.package.change', ['division' => $division]) : route('manage.division.info', ['division' => $division]):route('manage.division.info', ['division' => $division]) }}" class="btn btn-primary btn-block">Go to my league</a>
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
