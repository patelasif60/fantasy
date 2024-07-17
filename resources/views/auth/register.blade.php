@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/auth/register.js') }}"></script>
@endpush

@push('header-content')
    @include('partials.auth.header', ['title' => "Join Fantasy League"])
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
                                        <a href="{{ (url()->previous() == url()->current())? route('landing'):url()->previous() }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                                    </li>
                                    <li class="text-center">Join Fantasy League</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

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
                                @if(has_join_league_request(Session::get('url.intended')))
                                <div class="custom-alert alert-tertiary" role = "alert">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-dark">
                                        @php ($division = division_name_for_invite(session::get('url.intended')))
                                        You've been invited to join the {{ $division->name }} by {{ $division->consumer->user->first_name }} {{ $division->consumer->user->last_name }}.
                                    </div>
                                </div>
                                @endif

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <label>Join with</label>
                                    </div>
                                </div>

                                <div class="row gutters-md">
                                    <div class="col-6">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-secondary btn-block has-icon">
                                            <i class="fab fa-google"></i>  Google
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-secondary btn-block has-icon">
                                            <i class="fab fa-facebook"></i> Facebook
                                        </a>
                                    </div>
                                </div>

                                <div class="divider mt-4 mb-3"></div>
                                <form class="js-register-form" action="{{ route('register')  }}" method="POST">
                                        @csrf

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name') }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                            <label for="EmailAddress">Email Address</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
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
                                        <input type="checkbox" class="custom-control-input" id="remember" name = "remember">
                                        <label class="custom-control-label" for="remember">Keep me logged in</label>
                                    </div>
                                </div>

                                <label>Please send me:</label>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="has_games_news" name="has_games_news" >
                                        <label class="custom-control-label" for="has_games_news">News about game updates</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="has_third_parities" name="has_third_parities">
                                        <label class="custom-control-label" for="has_third_parities">News from our partners</label>
                                    </div>
                                </div>


                                <p class="small">By tapping 'Register' you are agreeing to the <a href="{{ route('frontend/terms') }}" target="_blank" class="text-white"><u>Terms of Service</u></a> and <a href="{{ route('frontend/privacy') }}" target="_blank" class="text-white"><u>Privacy Policy</u></a></p>

                                <div class="row gutters-md">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-gray btn-block text-white">Register</button>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <a href="{{ route('login') }}" class="btn btn-secondary btn-block">Log in to an existing account</a>
                                    </div>
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
