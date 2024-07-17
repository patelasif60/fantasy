@extends('layouts.manager')

@push('header-content')
    {{-- @include('partials.auth.header') --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('landing') }}"><span>
                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                        </a>
                    </li>
                    <li class="text-center">Update Profile</li>
                    <li class="text-right">
                        @include('partials.manager.more_menu')
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/profile/incomplete.js') }}"></script>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <form class="js-profile-update-form text-white" action="{{ route('manager.incomplete.profile.save') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="container-wrapper">
                <div class="container-body">
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
                            <div class="mt-4"></div>
                        </div>

                        <div class="col-12 col-md-11">
                            <div class="row justify-content-center">
                                <div class ="custom-alert alert-tertiary text-dark">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>
                                    <div class="alert-text">
                                        We need a few more details to finish setting up your account.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                                        <label for="first_name" class="required">First name:</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="Enter first name">
                                        @if ($errors->has('first_name'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                                        <label for="last_name" class="required">Last name:</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Enter last name">
                                        @if ($errors->has('last_name'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                    Please Send me:
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="1" id="has_games_news" name="has_games_news" @if($user->consumer->has_games_news) checked @endif>
                                        <label class="custom-control-label" for="has_games_news">News about game updates</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="1" id="has_third_parities" name="has_third_parities" @if($user->consumer->has_third_parities) checked @endif>
                                        <label class="custom-control-label" for="has_third_parities">News from our partners</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <div class="row justify-content-center text-white">
                        <div class="col-12 col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('landing') }}"  class="btn btn-secondary btn-block">Back</a>
                                </div>
                                <div class="col-md-6 pt-3 pt-md-0">
                                     <button type="submit" class="btn btn-block btn-primary">
                                     @if($user->remember_url != '')
                                        Save and Continue
                                     @else
                                        Update Profile
                                    @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- <div class="auth-card card-img-bg">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ route('landing') }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Update Profile</li>
                                    <li class="text-right">
                                        @include('partials.manager.more_menu')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                    <div class="mt-4"></div>
                    <form class="js-profile-update-form text-white" action="{{ route('manager.incomplete.profile.save') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="auth-card-content-body">
                            <div class="col-12 col-md-11">
                                <div class="row justify-content-center">
                                    <div class ="custom-alert alert-tertiary text-dark">
                                        <div class="alert-icon">
                                            <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                        </div>
                                        <div class="alert-text">
                                            We need a few more details to finish setting up your account.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                                            <label for="first_name" class="required">First name:</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="Enter first name">
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feedback animated fadeInDown">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                                            <label for="last_name" class="required">Last name:</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Enter last name">
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feedback animated fadeInDown">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label>
                                        Please Send me:
                                        </label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" id="has_games_news" name="has_games_news" @if($user->consumer->has_games_news) checked @endif>
                                            <label class="custom-control-label" for="has_games_news">News about game updates</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" id="has_third_parities" name="has_third_parities" @if($user->consumer->has_third_parities) checked @endif>
                                            <label class="custom-control-label" for="has_third_parities">News from our partners</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('landing') }}"  class="btn btn-secondary btn-block">Back</a>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                         <button type="submit" class="btn btn-block btn-primary">
                                         @if($user->remember_url != '')
                                            Save and Continue
                                         @else
                                            Update Profile
                                        @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div> --}}
    </div>
</div>
@endsection
