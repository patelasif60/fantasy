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
                                    <li class="text-center">Forgot Password</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                                @if (session('status'))
                                <div class="custom-alert alert-primary text-dark">
                                        <div class="alert-icon text-center">
                                            {{-- <img  src="{{ asset('/assets/frontend/img/cta/icon-yellow-card.svg') }}" alt="alert-img"> --}}
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="alert-text ">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ route('password.email') }}" method="post">
                                    @csrf
                                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                        <label for="EmailAddress">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Send password reset link</button>
                                        </div>

                                        <div class="form-group text-center">
                                            <a href="{{ route('login') }}" class="text-white f-14"><u>Go to sign in page</u></a>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
