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
                                    <li class="text-center">Login</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                        <label for="EmailAddress">Username or Email Address</label>
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
                                                    <i toggle="#password" class="fas fa-eye toggle-password"></i>
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
                                            <input type="checkbox" class="custom-control-input" id="logged-in" checked="">
                                            <label class="custom-control-label" for="logged-in">Keep me logged in</label>
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
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <label>Login in using</label>
                                    </div>
                                </div>

                                <div class="row gutters-md">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-secondary btn-block has-icon">
                                            <i class="fab fa-google"></i>  Google
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-secondary btn-block has-icon">
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
    </div>
</div>

@endsection
