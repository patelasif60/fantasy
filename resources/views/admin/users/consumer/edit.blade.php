@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/admin/users/consumer/edit.js') }}"></script>
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
<form method="POST" class="js-consumer-update-form" action="{{ route('admin.users.consumers.update', ['user' => $user]) }}"  enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Consumer</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                        <label for="first_name" class="required">First name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="First name">
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
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Last name">
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
                        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Email address">
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
                        value="{{ isset($user->consumer->dob) ? carbon_format_to_date($user->consumer->dob) : '' }}"
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
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" placeholder="Username">
                        @if ($errors->has('username'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('username') }}</strong>
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
                                    <input type="radio" class="css-control-input" name="status" value="{{ $key }}" @if($key === $user->status) checked @endif>
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
                                <input type="checkbox" class="css-control-input" value="1" id="has_games_news" name="has_games_news" @if($user->consumer->has_games_news) checked @endif>
                                <span class="css-control-indicator"></span> Game news
                            </label>
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" value="1" id="has_third_parities" name="has_third_parities" @if($user->consumer->has_third_parities) checked @endif>
                                <span class="css-control-indicator"></span> 3rd Parties
                            </label>
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
            <h3 class="block-title">Contact details</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('address_1') ? ' is-invalid' : '' }}">
                        <label for="address_1" class="required">Address 1:</label>
                        <input type="text" class="form-control" id="address_1" name="address_1" value="{{ $user->consumer->address_1 }}" placeholder="Address 1">
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
                        <input type="text" class="form-control" id="address_2" name="address_2" value="{{ $user->consumer->address_2 }}" placeholder="Address 2">
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
                        <input type="text" class="form-control" id="town" name="town" value="{{ $user->consumer->town }}" placeholder="Town">
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
                            <input type="text" class="form-control" id="county" name="county" value="{{ $user->consumer->county }}" placeholder="County">
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
                        <input type="text" class="form-control" id="post_code" name="post_code" value="{{ $user->consumer->post_code }}" placeholder="Postcode">
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
                        <input type="text" class="form-control" id="country" name="country" value="{{ $user->consumer->country }}" placeholder="Country">
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
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $user->consumer->telephone }}" placeholder="Phone number">
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
                        <input type="file" name="avatar" id="avatar" data-fileuploader-files='{{ $avatar }}'>
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
                        <input type="text" class="form-control" id="favourite_club" name="favourite_club" value="{{ $user->consumer->favourite_club }}" placeholder="Favourite club">
                        @if ($errors->has('favourite_club'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('favourite_club') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('introduction') ? ' is-invalid' : '' }}">
                        <label for="introduction">Introduction:</label>
                        <textarea class="form-control" id="introduction" rows="8" name="introduction" placeholder="Introduction">{{ $user->consumer->introduction }}</textarea>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update consumer</button>
        <a href="{{ route('admin.users.consumers.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
        <a href="#" data-toggle="modal" data-target="#modal-hijack-consumer" class="btn btn-hero btn-noborder btn-alt-primary float-right">Hijack</a>
    </div>
</form>
@stop

@push('modals')
    <div class="modal fade" id="modal-hijack-consumer" tabindex="-1" role="dialog" aria-labelledby="modal-hijack-consumer" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Hijack user</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="alert alert-warning alert-important" role="alert">Click the button below to generate a single-use password for <span class="font-weight-bold">{{ $user->email }}</span></div>
                        <button class="btn btn-noborder btn-noborder btn-primary js-hijack-consumer" data-url="{{ route('admin.users.admin.hijack', ['user' => $user]) }}">Generate password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-hijack-consumer-result" tabindex="-1" role="dialog" aria-labelledby="modal-hijack-consumer-result" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Hijack user</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="alert alert-warning alert-important" role="alert">Below single-use password has been generated for <span class="font-weight-bold">{{ $user->email }}</span>. The password will stop working after an hour and cannot be viewed again once this popup is closed.</div>
                        <div class="row">
                            <div class="col-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control js-single-use-password-value" id="single-use-password-value" value="" readonly="readonly">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary js-single-use-password-copy" data-clipboard-target="#single-use-password-value" data-trigger="manual" data-toggle="tooltip" title="Copied!"><i class="fal fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-noborder" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
