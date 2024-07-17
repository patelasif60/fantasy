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
                    {{-- <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ url()->previous() }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Login</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-12 col-xl-10">
                                <div class="custom-alert alert-tertiary">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-dark">
                                        <p class="mb-0">Current users logging into the 19/20 site for the first time: Please click on the <a href="{{ route('password.request') }}">Forgotten your password</a> link to reset your password as your previous password is no longer valid.</br class="d-none d-xl-inline-block"><br>Please ensure that you use the same email address as used previously to access your league, pre-populated with last season's teams.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-lg-6 col-xl-5">
                                <form action="{{ route('login') }}" method="POST" class="login-form">
                                    @csrf
                                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                        <label for="EmailAddress">Email Address</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control border-right-0" id="password" name="password" aria-label="Password visibility check">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-white">
                                                    <i toggle="#password" class="fas fa-eye-slash toggle-password"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember" checked="" name="remember">
                                            <label class="custom-control-label" for="remember">Keep me logged in</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('password.request') }}" class="text-white f-14"><u>Forgotten your password?</u></a>
                                    </div>
                                </form>
                            </div>

                            <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
                                <div class="text-center"><label>Login in using</label></div>

                                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-secondary btn-block has-icon">
                                    <i class="fab fa-google"></i>  Google
                                </a>

                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-secondary btn-block has-icon">
                                    <i class="fab fa-facebook"></i> Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
