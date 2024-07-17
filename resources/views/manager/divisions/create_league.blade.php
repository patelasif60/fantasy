@extends('layouts.manager')

{{-- @push('header-content')
    @include('partials.auth.header')
@endpush --}}

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/create.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        @if(request()->get('from') === 'more')
                            <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif" }} "><span>
                                <i class="fas fa-chevron-left mr-2"></i></span>Back
                            </a>
                        @else
                            <a href="{{ route('manager.incomplete.profile.edit') }} ">
                                <i class="fas fa-chevron-left mr-2"></i></span>Back
                            </a>
                        @endif

                    </li>
                    <li class="text-center">Create Your League</li>
                    <li class="text-right">
                        @include('partials.manager.more_menu')
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <form class="js-division-form" action="{{ route('manager.division.save', ['package' => $package]) }}" method="post">
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{$user->first_name}}'s League" value ="{{$user->first_name}}'s League">
                            </div>
                            <p>This is your default league name. If you’re struggling for inspiration you’ll be able to change it later.</p>
                        </div>
                    </div>
                </div>

                <div class="container-body">
                    <div class="row justify-content-center text-white">
                        <div class="col-12 col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('manager.incomplete.profile.edit')}}"  class="btn btn-secondary btn-block">Back</a>
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
</div>

@endsection
