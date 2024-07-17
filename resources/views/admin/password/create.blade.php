@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/password/create.js') }}"></script>
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

<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Change Password</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option">
                <i class="si si-wrench"></i>
            </button>
        </div>
    </div>
    <div class="block-content block-content-full">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <form class="js-password-update-form" action="{{ route('admin.users.update.password') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('current_password') ? ' is-invalid' : '' }}">
                        <label for="current_password" class="required">Current password:</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        @if ($errors->has('current_password'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <label for="password" class="required">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        <label for="password_confirmation" class="required">Confirm password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-alt-primary">Save password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
