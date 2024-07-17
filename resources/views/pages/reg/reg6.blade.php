@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li></li>
                                    <li class="text-center">All done</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <div class="complete-registration text-center">
                                    <img src="{{ asset('assets/frontend/img/ball.svg')}}" alt="" class="img-ball">
                                    <h4 class="font-weight-bold">Ready to Kick-Off!</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</p>

                                    <div class="row justify-content-center mt-4">
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
                                    </div>

                                    <div class="my-5"></div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-primary btn-block">Done</button>
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
</div>

@endsection
