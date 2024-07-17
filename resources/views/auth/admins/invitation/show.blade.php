@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header', ['title' => "Set password"])
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
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="row mb-100">
                                <div class="col-12 text-white">
                                    <form class="js-reset-form" action="{{ route('auth.users.admin.invitation.accept', ['token' => $token]) }}" method="POST">
                                        @csrf
                                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $invite->user->email }}" autofocus disabled="disabled">
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
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                                            <label for="password_confirmation">Confirm password</label>
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
                                            <button type="submit" class="btn btn-primary btn-block">Set up password</button>
                                        </div>
                                        <div class="text-center f-12">
                                            By clicking “Create account”, you agree to our <a href="#" data-toggle="modal" data-target="#modal-terms" class="text-white">terms of service</a> and <a href="#" data-toggle="modal" data-target="#modal-terms" class="text-white">privacy statement</a>.
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

@push('modals')
    @include('partials.auth.modals.terms')
@endpush