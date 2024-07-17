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
                                    <li class="text-center">Join Fantasy League</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="progressbar-area">
                                    <div class="progessbar-bg">
                                        <div class="bar-block"></div>
                                    </div>
                                    <ul class="stepper">
                                        <li class="active">Profile</li>
                                        <li>League</li>
                                        <li>Friends</li>
                                        <li>Team</li>
                                    </ul>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <label>Join with</label>
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

                                <div class="divider mt-3 mb-2"></div>

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first-name">First Name</label>
                                            <input type="text" class="form-control" id="first-name" name="first-name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last-name">Last Name</label>
                                            <input type="text" class="form-control" id="last-name" name="first-name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                            <label for="EmailAddress">Username or Email Address</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" autofocus>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback animated fadeInDown" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="logged-in" checked="">
                                        <label class="custom-control-label" for="logged-in">Keep me logged in</label>
                                    </div>
                                </div>

                                <label>Please send me:</label>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="game-update" checked="">
                                        <label class="custom-control-label" for="game-update">News about game updates</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="news-partner">
                                        <label class="custom-control-label" for="news-partner">News from our partners</label>
                                    </div>
                                </div>

                                <p class="small">By tapping 'Create Account' you are agreeing to the <a href="" class="text-white"><u>Terms of Service</u></a> and <a href="" class="text-white"><u>Privacy Policy</u></a></p>

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <button type="submit" class="btn btn-secondary btn-block">Log in to an existing account</button>
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
