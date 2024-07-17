@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/auth/reset_pwd.js') }}"></script>
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
                                    <li class="text-center">Reset Password</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                                <form class="js-reset-form" action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                        <label for="EmailAddress">Email Address</label>
                                        <input type="email" class="form-control" readonly="readonly" id="email" name="email" value="{{ $email ?? old('email') }}" autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                        <label for="password">New password</label>
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
                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                                        <label for="password_confirmation">Confirm new password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control border-right-0" id="password" name="password_confirmation" aria-label="Password visibility check">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-white">
                                                    <i toggle="#password_confirmation" class="fas fa-eye toggle-password"></i>
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
                                        <button type="submit" class="btn btn-primary btn-block" disabled>Reset password</button>
                                    </div>
                                    {{-- <div class="text-center">
                                        <a href="{{ route('password.request') }}" class="text-white f-14"><u>Forgotten your password?</u></a>
                                    </div> --}}
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
                                        <label>New to Fantasy League?</label>
                                    </div>
                                </div>

                                <div class="row gutters-md">
                                    <div class="col-md-12">
                                       <a href="{{ route('register') }}" class="btn btn-outline-white btn-block">
                                        Create an Account
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
