@extends('layouts.manager')

{{-- @push('header-content')
    @include('partials.auth.header')
@endpush --}}

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ url()->previous() }}"><span>
                            <i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center">Create Your Team</li>
                    <li class="text-right">
                        @if($skipUrl != null)
                        <a href="{{ $skipUrl }}">
                            Skip<span>
                            <i class="fas fa-chevron-right ml-2"></i></span>
                        </a>
                        @else
                            @include('partials.manager.more_menu')
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/create_team.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/manager/divisions/choose_crest.js') }}"></script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <form class="js-create-team-form" action="{{ route('manage.division.team.store', ['division' => $division])}} " method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('flash::custom-message')
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
                                    <li class="completed">League</li>
                                    <li class="completed">Friends</li>
                                    <li class="active">Team</li>
                                </ul>
                            </div>
                            <div class="mt-4"></div>
                            @if(($via) && ($via == 'join' || $via == 'invite'  || $via == 'social'))
                            <input type="hidden" name="via" value="{{$via}}">
                            <div class="custom-alert alert-tertiary" role = "alert">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text text-dark">
                                    Welcome to {{$division->name}}. Create your team to join this league.
                                </div>
                            </div>
                            @endif
                            <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                <label for="team-name">Team Name</label>
                                <input type="text"  class="form-control" id="name" name="name" placeholder="{{$user->first_name}}'s Team" value = "{{$user->first_name}}'s Team" maxlength="100">
                            </div>
                            @mobile
                                @php
                                    $crestChunks = $crests->chunk(9)
                                @endphp
                            @elsemobile
                                @php
                                    $crestChunks = $crests->chunk(18)
                                @endphp
                            @endmobile
                            @php
                                $count = 0;
                                $tabs = count($crestChunks)
                            @endphp

                            <div class="team-creation team-carousel">
                                <div class="form-group mb-10">
                                    <label for="team-icon">team crest</label>
                                </div>
                                <div class="team-selection owl-carousel owl-theme">
                                    @foreach ($crestChunks as $crestKey => $chunks)
                                        <div class="item @if($crestKey==0) active @endif">
                                            <div class="row gutters-sm">
                                                @foreach ($chunks as $key => $crest)
                                                    @if($crest->getMedia('crest')->last())
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="crest_id{{$key}}" name="crest_id" class="custom-control-input" value="{{$crest->id}}">
                                                                <label class="custom-control-label w-100" for="crest_id{{$key}}">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ $crest->getMedia('crest')->last()->getUrl('thumb') }}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <div class="row justify-content-center text-white mt-5">
                        <div class="col-12 col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                                    <div class="upload-crest">
                                        <input type="file" name="crest" id="crest">
                                    </div>
                                    @if ($errors->has('crest'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('crest') }}</strong>
                                        </div>
                                    @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-gray btn-block js-create-team text-white" disabled>Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- <div class="auth-card">
            <div class="auth-card-body">

                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ url()->previous() }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Create Your Team</li>
                                    <li class="text-right">
                                        @if($skipUrl != null)
                                        <a href="{{ $skipUrl }}">
                                            Skip&nbsp;&nbsp;<span>
                                            <i class="fas fa-chevron-right"></i></span>
                                        </a>
                                        @else
                                            @include('partials.manager.more_menu')
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <form class="js-create-team-form" action="{{ route('manage.division.team.store', ['division' => $division])}} " method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include('flash::custom-message')
                        <div class="auth-card-content-body">
                            <div class="row justify-content-center text-white">
                                <div class="col-12 col-md-11">
                                    <div class="progressbar-area">
                                        <div class="progessbar-bg">
                                            <div class="bar-block"></div>
                                        </div>
                                        <ul class="stepper">
                                            <li class="completed">Profile</li>
                                            <li class="completed">League</li>
                                            <li class="completed">Friends</li>
                                            <li class="active">Team</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4"></div>
                                    @if(($via) && ($via == 'join' || $via == 'invite'  || $via == 'social'))
                            <input type="hidden" name="via" value="{{$via}}">
                            <div class="custom-alert alert-tertiary" role = "alert">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text text-dark">
                                    Welcome to {{$division->name}}. Create your team to join this league.
                                </div>
                            </div>
                            @endif
                                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                        <label for="team-name">Team Name</label>
                                        <input type="text"  class="form-control" id="name" name="name" placeholder="{{$user->first_name}}'s Team" value = "{{$user->first_name}}'s Team" maxlength="100">
                                    </div>
                                    @mobile
                                        @php
                                            $crestChunks = $crests->chunk(9)
                                        @endphp
                                    @elsemobile
                                        @php
                                            $crestChunks = $crests->chunk(18)
                                        @endphp
                                    @endmobile
                                    @php
                                        $count = 0;
                                        $tabs = count($crestChunks)
                                    @endphp

                                    <div class="team-creation team-carousel">
                                        <div class="form-group mb-10">
                                            <label for="team-icon">Please select a team badge or upload your own icon.</label>
                                        </div>
                                        <div class="team-selection owl-carousel owl-theme">
                                            @foreach ($crestChunks as $crestKey => $chunks)
                                                <div class="item @if($crestKey==0) active @endif">
                                                    <div class="row gutters-sm">
                                                        @foreach ($chunks as $key => $crest)
                                                            @if($crest->getMedia('crest')->last())
                                                                <div class="col-4 col-md-3 col-lg-2">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="crest_id{{$key}}" name="crest_id" class="custom-control-input" value="{{$crest->id}}">
                                                                        <label class="custom-control-label w-100" for="crest_id{{$key}}">
                                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ $crest->getMedia('crest')->last()->getUrl('thumb') }}" alt="">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="auth-card-content">
                            <div class="auth-card-footer">
                                <div class="row justify-content-center text-white mt-5">
                                    <div class="col-12 col-md-11">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                                                <div class="upload-crest">
                                                    <input type="file" name="crest" id="crest">
                                                </div>
                                                @if ($errors->has('crest'))
                                                    <div class="invalid-feedback animated fadeInDown">
                                                        <strong>{{ $errors->first('crest') }}</strong>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-gray btn-block js-create-team text-white" disabled>Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>
</div>



@endsection
