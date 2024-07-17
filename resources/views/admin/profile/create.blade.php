@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/profile/create.js') }}"></script>
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

<form class="js-profile-update-form" action="{{ route('admin.users.update.profile') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Profile</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
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

                <div class="col-xl-6">
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

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="e.g. example@example.com">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6"></div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update Profile</button>
        </div>
    </div>
</form>
@endsection
