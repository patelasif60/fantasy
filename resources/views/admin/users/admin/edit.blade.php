@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/users/admin/edit.js') }}"></script>
@endpush

@section('content')

<form class="js-admin-update-form" action="{{ route('admin.users.admin.update', ['user' => $user]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Admin User</h3>
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
                    <div class="form-group{{ $errors->has('role') ? ' is-invalid' : '' }}">
                        <label for="role" class="required">User type:</label>
                        <select class="form-control js-select2" id="role" name="role">
                            <option value="">Please select</option>
                             @foreach($roles as $key => $role)
                                <option value="{{ $key }}" @if($user->hasRole($key)) selected @endif>{{$role}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('role') }}</strong>
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
                </div>

                <div class="col-xl-6">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update user</button>
        <a href="{{ route('admin.users.admin.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
