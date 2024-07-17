@extends('layouts.auth.selection')

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-content-body">
                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="crest-logo text-center">
                                    <a href="{{ route('landing') }}">
                                        <img class="lazyload d-inline" src="{{ asset('assets/frontend/img/crest-logo/crest-thumb.png')}}" data-src="{{ asset('assets/frontend/img/crest-logo/crest.png')}}" data-srcset="{{ asset('assets/frontend/img/crest-logo/crest.png')}} 1x, {{ asset('assets/frontend/img/crest-logo/crest@2x.png')}} 2x" alt="">
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-lg-7">
                                @include('flash::message')
                                @guest
                                <a href="{{ route('auth.register.select',['next' => 'create']) }}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        {{-- <img src="{{ asset('assets/frontend/img/cup/cup1.svg')}}" alt="" class="img-cup lazyload"> --}}
                                        <div><i class="fl fl-trophy img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Create a League
                                            </h4>
                                            <p>Click here to set up your own league.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('auth.register.select',['next' => 'join']) }}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        {{-- <img src="{{ asset('assets/frontend/img/cup/cup2.svg')}}" alt="" class="img-cup lazyload"> --}}
                                        <div><i class="fl fl-winners img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Join a League
                                            </h4>
                                            <p>Click here to join an existing Private or Social league.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{route('login')}}" class="btn btn-primary btn-block mt-5">
                                    Login to an existing account
                                </a>
                                @endguest
                                @auth
                                    @hasanyrole('superadmin|staff')
                                        <a class="btn btn-primary btn-block mt-5"href="{{ route('admin.dashboard.index') }}">
                                           Go to dashboard
                                        </a>
                                    @endhasrole
                                    @hasrole('user')
                                        <a href="{{ route('manage.division.create') }}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        {{-- <img src="{{ asset('assets/frontend/img/cup/cup1.svg')}}" alt="" class="img-cup"> --}}
                                        <div><i class="fl fl-trophy img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Create a League
                                            </h4>
                                            <p>Click here to set up your own league.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('manage.division.join.league.select') }}" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        {{-- <img src="{{ asset('assets/frontend/img/cup/cup2.svg')}}" alt="" class="img-cup"> --}}
                                        <div><i class="fl fl-winners img-cup"></i></div>
                                        <div class="content-wrapper">
                                            <h4 class="font-weight-bold text-uppercase pr-4">
                                                Join a League
                                            </h4>
                                            <p>Click here to join an existing Private or Social league.</p>
                                        </div>
                                    </div>
                                </a>
                                 <a class="btn btn-primary btn-block mt-5" href="{{ route('manage.division.teams.index') }}">
                                     Go to My League
                                </a>
                                    @endhasrole
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


