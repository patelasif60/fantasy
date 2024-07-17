@extends('layouts.manager')

{{-- @push('header-content')
    @include('partials.auth.header')
@endpush --}}

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manager.incomplete.profile.edit') }}"><span>
                            <i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center">Create your league</li>
                    <li class="text-right"></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/edit.js') }}"></script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <form class="js-division-form" action="{{ route('manage.division.updateName', ['division' => $division]) }}" method="post">
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
                                    <li class="completed">Profile</li>
                                    <li class="active">League</li>
                                    <li>Friends</li>
                                    <li>Team</li>
                                </ul>
                            </div>
                            <div class="mt-4"></div>
                            <div class="form-group">
                                <label for="name">League name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{$division->name}}" value ="{{$division->name}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <div class="row justify-content-center text-white">
                        <div class="col-12 col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('manager.incomplete.profile.edit') }}"  class="btn btn-secondary btn-block">Back</a>
                                </div>
                                <div class="col-md-6 pt-3 pt-md-0">
                                    <button type="submit" class="btn btn-primary btn-block create-team">Next</button>
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
                                        <a href="{{ route('manager.incomplete.profile.edit') }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Create your league</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <form class="js-division-form" action="{{ route('manage.division.updateName', ['division' => $division]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="progressbar-area">
                                    <div class="progessbar-bg">
                                        <div class="bar-block"></div>
                                    </div>
                                    <ul class="stepper">
                                        <li class="completed">Profile</li>
                                        <li class="active">League</li>
                                        <li>Friends</li>
                                        <li>Team</li>
                                    </ul>
                                </div>
                                <div class="mt-4"></div>
                                <div class="form-group">
                                    <label for="name">League name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{{$division->name}}" value ="{{$division->name}}">
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
                                        <a href="{{ route('manager.incomplete.profile.edit') }}"  class="btn btn-secondary btn-block">Back</a>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <button type="submit" class="btn btn-primary btn-block create-team">Next</button>
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
