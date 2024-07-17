@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/users/consumer/create.js') }}"></script>
@endpush

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" class="js-consumer-create-form" action="{{ route('admin.users.consumers.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Consumer</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                        <label for="first_name" class="required">First name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First name">
                        @if ($errors->has('first_name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                        <label for="last_name" class="required">Last name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                        @if ($errors->has('last_name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="email" class="required">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email address">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('dob') ? ' is-invalid' : '' }}">
                        <label for="dob" class="required">Date of brith:</label>
                        <input type="text" class="form-control js-datepicker"
                        id="dob"
                        name="dob"
                        value="{{ old('dob') }}"
                        placeholder="Date of birth"
                        data-date-format="{{config('fantasy.datepicker.format')}}"
                        data-date-end-date="0d"
                        data-week-start="1"
                        data-autoclose="true"
                        data-today-highlight="true"
                        autocomplete="off">
                        @if ($errors->has('dob'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('username') ? ' is-invalid' : '' }}">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="Username">
                        @if ($errors->has('username'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <label for="password" class="required">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Password">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('status') ? ' is-invalid' : '' }}">
                        <label for="status">Status:</label>
                        <div class="row no-gutters items-push">
                            @foreach($status as $key => $value)
                                <label class="css-control css-control-primary css-radio">
                                    <input type="radio" class="css-control-input" name="status" value="{{ $key }}" @if($key === old('status', \App\Enums\UserStatusEnum::__default)) checked @endif>
                                    <span class="css-control-indicator"></span> {{ $value }}
                                </label>
                            @endforeach
                            @if ($errors->has('status'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label>GDPR:</label>
                        <div class="row no-gutters items-push">
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" value="1" id="has_games_news" name="has_games_news" @if(old('has_games_news')) checked @endif>
                                <span class="css-control-indicator"></span> Game news
                            </label>
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" value="1" id="has_third_parities" name="has_third_parities" @if(old('has_third_parities')) checked @endif>
                                <span class="css-control-indicator"></span> 3rd Parties
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Contact details</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('address_1') ? ' is-invalid' : '' }}">
                        <label for="address_1" class="required">Address 1:</label>
                        <input type="text" class="form-control" id="address_1" name="address_1" value="{{ old('address_1') }}" placeholder="Address 1">
                        @if ($errors->has('address_1'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('address_1') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('address_2') ? ' is-invalid' : '' }}">
                        <label for="address_2">Address 2:</label>
                        <input type="text" class="form-control" id="address_2" name="address_2" value="{{ old('address_2') }}" placeholder="Address 2">
                        @if ($errors->has('address_2'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('address_2') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('town') ? ' is-invalid' : '' }}">
                        <label for="town">Town/City:</label>
                        <input type="text" class="form-control" id="town" name="town" value="{{ old('town') }}" placeholder="Town/city">
                        @if ($errors->has('town'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('town') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('county') ? ' is-invalid' : '' }}">
                        <label for="county">County:</label>
                        <div class="row no-gutters items-push">
                            <input type="text" class="form-control" id="county" name="county" value="{{ old('county') }}" placeholder="County">
                            @if ($errors->has('county'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('county') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('post_code') ? ' is-invalid' : '' }}">
                        <label for="post_code" class="required">Postcode:</label>
                        <input type="text" class="form-control" id="post_code" name="post_code" value="{{ old('post_code') }}" placeholder="Postcode">
                        @if ($errors->has('post_code'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('post_code') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('country') ? ' is-invalid' : '' }}">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" placeholder="Country">
                        @if ($errors->has('country'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('country') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('telephone') ? ' is-invalid' : '' }}">
                        <label for="telephone">Phone:</label>
                        <div class="row no-gutters items-push">
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}" placeholder="Phone number">
                            @if ($errors->has('telephone'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Profile</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('avatar') ? ' is-invalid' : '' }}">
                        <label for="photo">Photo:</label>
                        <input type="file" name="avatar" id="avatar">
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                        @if ($errors->has('avatar'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('favourite_club') ? ' is-invalid' : '' }}">
                        <label for="favourite_club">Favourite club:</label>
                        <input type="text" class="form-control" id="favourite_club" name="favourite_club" value="{{ old('favourite_club') }}" placeholder="Favourite club">
                        @if ($errors->has('favourite_club'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('favourite_club') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('introduction') ? ' is-invalid' : '' }}">
                        <label for="introduction">Introduction:</label>
                        <textarea class="form-control" id="introduction" rows="8" name="introduction" placeholder="Introduction">{{ old('introduction') }}</textarea>
                        @if ($errors->has('introduction'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('introduction') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create consumer</button>
        <a href="{{ route('admin.users.consumers.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
