@extends('layouts.auth.selection')

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
                                    <li>
                                        <a href="{{ route('landing') }}">
                                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                        </a>
                                    </li>
                                    <li class="text-center">Join a League</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <div class="auth-card-content-body">
                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="crest-logo text-center d-none d-md-block">
                                    <a href="{{ route('landing') }}">
                                        <img class="lazyload d-inline" src="{{ asset('assets/frontend/img/crest-logo/crest-thumb.png')}}" data-src="{{ asset('assets/frontend/img/crest-logo/crest.png')}}" data-srcset="{{ asset('assets/frontend/img/crest-logo/crest.png')}} 1x, {{ asset('assets/frontend/img/crest-logo/crest@2x.png')}} 2x" alt="">
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-lg-7">
                                <a href="{{route("manage.division.join.new.league")}}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        <div><i class="fl fl-trophy img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Join a Private League
                                            </h4>
                                            <p>Click here to join a league with friends.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{route("manage.division.join.new.social-league")}}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        <div><i class="fl fl-winners img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Join a Social League
                                            </h4>
                                            <p>Click here to join a league with other individual managers.</p>
                                        </div>
                                    </div>
                                </a>

                                <div class="text-center mt-5"><a href="{{ route('landing') }}" class="btn btn-secondary btn-block text-white">Back</a></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
