@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/invitation_code.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.join.new.league') }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                    </a>
                </li>
                <li class="text-center">Invitation code</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <p class="mb-5">If you have an invitation code, you can enter it into the box below.</p>

                            <form class="js-invitation-code-form" action="{{ route('manager.join.league.save') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('invitation_code') ? ' is-invalid' : '' }}">
                                    <label for="invitation_code" class="required">Invitation code</label>
                                    <input type="text" class="form-control" id="invitation_code" name="invitation_code" placeholder="e.g. X578DF148">
                                    @if ($errors->has('invitation_code'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('invitation_code') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="searchLeague">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
