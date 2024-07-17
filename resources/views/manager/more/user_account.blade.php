@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> --}}
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/account/settings.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        @if(isset($backUrl) && trim($backUrl) != "")
                            <a href="{{route($backUrl)}}">
                                <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                            </a>
                        @else
                            <a href="javascript:void(0);" onclick="javascript:history.back();">
                                <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                            </a>
                        @endif

                    </li>

                    <li>
                        {{-- <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
                            <span><i class="fas fa-bars"></i></span>
                        </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fl fl-bar"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">

                            <form action="{{ route('manage.account.settings.store') }}" method="POST" class="js-user-account-form" id = "js-user-account-form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <h6 class="section-title">Basic Information</h6>

                                <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}">

                                    <label for="first-name">First Name</label>
                                    <input type="text" class="form-control required" id="first_name" name="first_name" value="{{ ( $user->first_name ? $user->first_name : null ) }}">
                                </div>
                                <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" class="form-control required" id="last_name" name="last_name" value="{{ ( $user->last_name ? $user->last_name : null ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" class="form-control dob-datetimepicker"
                                            id="dob"
                                            name="dob"
                                            value="{{ ( $user->consumer->dob ? carbon_format_to_date($user->consumer->dob) : null ) }}"
                                            placeholder="DD/MM/YYYY"
                                            data-date-format="DD/MM/Y"
                                            data-date-end-date="0d"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Please send me:</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="has_games_news" id="has_games_news" @if($user->consumer->has_games_news) checked="checked" @endif >
                                        <label class="custom-control-label" for="has_games_news">News about game updates
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="has_third_parities" name = "has_third_parities" @if($user->consumer->has_third_parities) checked="checked" @endif>
                                        <label class="custom-control-label" for="has_third_parities">News from our partners</label>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ ( $user->email ? $user->email : null ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="form-group{{ $errors->has('username') ? ' is-invalid' : '' }}">
                                    <label for="username">Display Name</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ ( $user->username ? $user->username : null ) }}">
                                </div>

                                <h6 class="section-title">Contact details</h6>
                                <div class="form-group">
                                    <label for="address_1">Address 1</label>
                                    <textarea class="form-control" id="address_1" name="address_1" rows="1">{{ ( $user->consumer->address_1 ? $user->consumer->address_1 : null ) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="address_2">Address 2</label>
                                    <textarea class="form-control" id="address_2" name="address_2" rows="1" >{{ ( $user->consumer->address_2 ? $user->consumer->address_2 : null ) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="town">Town/City</label>
                                    <input type="text" class="form-control" id="town" name="town" value="{{ ( $user->consumer->town ? $user->consumer->town : null ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" value="{{ ( $user->consumer->country ? $user->consumer->country : null ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="post_code">Postcode</label>
                                    <input type="text" class="form-control" id="post_code" name="post_code" value="{{ ( $user->consumer->post_code ? $user->consumer->post_code : null ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select id="country_code" name="country_code" class="country-code-select2">
                                                <option value="+44" @if($user->consumer->country_code =='+44')selected="selected"@endif>+44</option>
                                                <option value="+91" @if($user->consumer->country_code =='+91')selected="selected"@endif>+91</option>
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{ ( $user->consumer->telephone ? $user->consumer->telephone : null ) }}">
                                    </div>
                                </div>

                                <h6 class="section-title">Profile</h6>
                                <div class="form-group">
                                    <label for="introduction">About me</label>
                                    <textarea class="form-control" id="introduction" name="introduction" rows="3">{{ ( $user->consumer->introduction ? $user->consumer->introduction : null ) }}</textarea>
                                </div>
                               <div class="form-group {{ $errors->has('avatar') ? ' is-invalid' : '' }}">
                                    <label for="photo">Photograph</label>
                                    <input type="file" name="avatar" id="avatar" data-fileuploader-files='{{ $avatar }}'>
                                    <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                                    @if ($errors->has('avatar'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('avatar') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="favourite_club" class="d-block">Favourite Premier League team</label>
                                    <select id="favourite_club" name="favourite_club" class="club-select2 input-group-addon">
                                          <option value="">Select Club</option>
                                            @foreach($clubs as $club)
                                                <option value="{{ $club }}" @if($club == $user->consumer->favourite_club) selected = "selected" @endif>{{ $club }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="saveAccount" class="btn btn-primary btn-block">Save and continue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
